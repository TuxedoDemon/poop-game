<?php
declare(strict_types=1);
namespace PoopData;

class PoopHeaders {

        public function __construct(){

            $this->initPoop();
            
        }

    private function initPoop(): void {

        $this->sendHeaders($this->headerWave1());

        if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
            $this->sendHeaders($this->headerWave2());
            new PoopStart();
        }else{
            $this->sendHeaders($this->headerWave3());
            echo 'oops that\'s a teapot';
        }

    }

    private function sendHeaders(array $headers): void {

        foreach($headers as &$header){
            \header($header);
        }

        unset($header);

    }

    private function headerWave1(): array {

        return [
            'Allow: POST, HEAD',
            'Cross-Origin-Resource-Policy: same-origin',
            'Content-Type: application/json',
        ];

    }

    private function headerWave2(): array {

        return [
            'HTTP/1.1 200 OK',
            'Expires: Mon, 26 Jul 1997 05:00:00 GMT',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'X-Toilet-Status: destroyed',
            'X-Pants-Status: not pooped',
        ];

    }

    private function headerWave3(): array {

        return [    
            "HTTP/1.1 418 I'm a teapot",
            'X-Pants-Status: pooped',
            'X-Toilet-Status: this is a teapot',
            'Content-Type: text/plain;charset=UTF-8',
        ];

    }

}