<?php
declare(strict_types=1);
namespace PoopData;

class PoopStart {

            private string $end = '';
            private array $event;
            private array $pooparr;
            private PoopLogic $logic;

        public function __construct(){

            $this->sendHeaders($this->headerWave1());

            if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST'){
                $this->sendHeaders($this->headerWave2());
                $this->logic = new PoopLogic();
                $this->runPoopSim();
                echo \json_encode($this->pooparr);
            }else{
                $this->sendHeaders($this->headerWave3());
                echo 'oops that\'s a teapot';
            }

        }

    private function sendHeaders(array $headers){

        foreach($headers as &$header){
            \header($header);
        }

        unset($header);

    }

    private function headerWave1(){

        return [
            'Allow: POST, HEAD',
            'Cross-Origin-Resource-Policy: same-origin',
            'Content-Type: application/json',
        ];

    }

    private function headerWave2(){

        return [
            'HTTP/1.1 200 OK',
            'Expires: Mon, 26 Jul 1997 05:00:00 GMT',
            'Cache-Control: no-cache',
            'Pragma: no-cache',
            'X-Toilet-Status: destroyed',
            'X-Pants-Status: not pooped',
        ];

    }

    private function headerWave3(){

        return [    
            "HTTP/1.1 418 I'm a teapot",
            'X-Pants-Status: pooped',
            'X-Toilet-Status: this is a teapot',
            'Content-Type: text/plain;charset=UTF-8',
        ];

    }

    private function preparePoopArr(){

        $pooparr[] = '<div class="poop-start"><p>Pooping...</p></div>'."\n";

        for($i = 0; $i < $this->logic->poops; $i++){
            if($i < 25 || ($i % 25) === 0){
                $pooparr[] = ($i !== 0 && $i !== 90000 && (($i % 10000) === 0)) ? $this->prepString($this->event[$i]) : '<li>poop</li>'."\n";
            }
        }

        $pooparr[] = $this->end;
        $pooparr = \array_filter(
            \array_values($pooparr)
        );

        $this->pooparr = $pooparr;

    }

    private function runPoopSim(){

        $this->logic->milestones === [] && $this->setPatheticEnd();

        if($this->end === ''){
            foreach($this->logic->milestones as $key => &$milestone){
                if($key === 8){
                    break;
                }
                $function = "milestone{$key}";
                $this->event[$milestone] = $this->{$function}();
            }
            unset($milestone);
        }
        
        $this->end = ($this->end === '') ? $this->setEndString('<br>... See a doctor!') : $this->end;
        $this->preparePoopArr();

    }

    private function milestone0(){

        switch(true){
            case $this->logic->screamed:
                return 'Screaming.....';
            case $this->logic->sweaty:
                return 'Sweating.....';
            default:
                return '';
        }
        
    }

    private function milestone1(): string {

        return $this->logic->cried ? 'Crying........' : '';       

    }

    private function milestone2(): string {

        return "Flushing.........";

    }

    private function milestone3(): string {

        return $this->logic->clogged ? 'Unclogging.......' : 'Flushing again......';

    }

    private function milestone4(): string {

        switch(true){
            case !$this->logic->clogged:
                return 'Flushing a third time...';
            case !$this->logic->flooding:
                return $this->logic->sweaty ? 'Plunger slipped and broke.....' : 'Flushing <em>again....</em>';
            default:
                $this->end = $this->setEndString('<br>... And lost your security deposit.');
                return 'Flooding.......';
        }

    }

    private function milestone5(): string {

        switch(true){
            case $this->logic->flooding:
                if($this->logic->drowning){
                    $this->end = $this->setEndString('<br>... And then died.');
                    return 'Drowning........';
                }
                return 'Assessing water damage....';
            case $this->logic->cried:
                if($this->logic->sweaty){
                    return $this->logic->clogged ? 'Swearing....' : 'Sobbing.....';
                }
                return 'Crying again.....';
            default:
                return $this->logic->sweaty && $this->logic->clogged ? 'Removing splinters.......' : 'Cleaning up......';
        }

    }

    private function milestone6(): string {

        switch(true){
            case $this->logic->drowning:
                if($this->logic->screamed){
                    $this->end = $this->setEndString('<br>... And your neighbors want you to move.');
                    return 'Police broke in, no longer drowning.......';
                }
                return '.... No longer drowning.';
            default:
                return 'Experiencing dietary remorse......';
        }

    }

    private function milestone7(): string {

        switch(true){
            case $this->logic->drowning:
                return $this->logic->screamed ? 'Being fined for screaming earlier.....' : '........';
            default:
                return ($this->logic->clogged || $this->logic->flooding) ? 'Calling a plumber.....' : 'Reconsidering dairy......';
        }
        
    }

    private function prepString(string $string): string {
        
        return '<li class="poop-message"><p>'. $string .'</p></li>'."\n";
        
    }

    private function setPatheticEnd(): void {

        $end = match(true){

            $this->logic->poops === 1 => "<br>.... Wow.\n",
            $this->logic->poops === 69 => "<br>... Haha, gross.\n",
            $this->logic->poops <= 5000 => "<br>... Flushable!\n",
            $this->logic->poops < 10000 => "<br>... Very normal\n!",

        };

        $this->end = $this->setEndString($end);

    }

    private function setEndString(string $end){

        $s = $this->logic->poops === 1 ? '' : 's';
        $formatted = \number_format($this->logic->poops);

        return "<div class=\"final\"><p>You Pooped: {$formatted} Time{$s}! {$end}<br><button id=\"poop-again\">Poop Again?</button></p></div>";

    }

}
