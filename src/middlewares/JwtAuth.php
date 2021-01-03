<?php

    namespace src\middlewares;

    use \Firebase\JWT\JWT;

    final class JwtAuth{

        private $jwt = NULL;
        private $key = NULL;
        private $decoded = NULL;

        public function __construct( $type )
        {
            switch ($type){

                case 'login':

                    $this->key = getenv('API_JWT_TOKEN');

                break;

            }

        }

        private function validateToken($headers){

            if(!isset($headers['HTTP_AUTHORIZATION'][0]) || strlen($headers['HTTP_AUTHORIZATION'][0]) === 0)
                throw new \Exception('Informe o token de autenticação');

            $this->jwt = $headers['HTTP_AUTHORIZATION'][0];

            $parts = explode(" ", $this->jwt);

            if(count($parts) !== 2)
                throw new \Exception('Token mal-formatado');

            if($parts[0] !== 'Bearer')
                throw new \Exception('Tipo de token desconhecido');

            $this->jwt = $parts[1];

         

        }

        private function decode(){

            $decoded = JWT::decode($this->jwt, $this->key, array('HS256'));
            $this->decoded = json_decode(json_encode($decoded), true);

        }

        private function checkExpirate(){

            if(!isset($this->decoded['exp']))
                throw new \Exception('Nenhuma data de expiração foi encontrada no token informado');

            if($this->decoded['exp'] !== 'no_expires')
                if($this->decoded['exp'] < time())
                    throw new \Exception("Token expirado em " .

                        date("d/m/Y", strtotime($this->decoded['exp'])) . " às " .
                        date("H:i:s", strtotime($this->decoded['exp']))

                    );


        }

        public function __invoke( $request, $response, $next )
        {

            try{

                $this->validateToken($request->getHeaders());
                $this->decode();
                $this->checkExpirate();

                if(isset($this->decoded['sessao']['usuario']))
                    $request = $request->withAttribute('usuario', $this->decoded['sessao']['usuario']);

                $response = $next( $request, $response, null);

            }catch(\Exception $e){

                $response = $response->withJson([

                    "message" => $e->getMessage()

                ])->withStatus(401);

            }

            return $response;

        }

    }