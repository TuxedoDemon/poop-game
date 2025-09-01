<?php
declare(strict_types=1);
namespace PoopData;

class PoopStart {

            private string $end = '';
            private array $event;
            private PoopLogic $logic;

        public function __construct(){

            $this->logic = new PoopLogic();
            $this->runPoopSim();

        }

    private function runPoopSim(): void {

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
        
        ($this->end === '') && $this->end = $this->setEndString('<br>... See a doctor!');
        $this->preparePoopArr();

    }

    private function milestone0(): string {

        $words = match(true){

            $this->logic->screamed => 'Screaming.....',
            $this->logic->sweaty => 'Sweating.....',
            default => '',

        };

        return $words;
        
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

        $words = match(true){

            !$this->logic->clogged => 'Flushing a third time...',
            !$this->logic->flooding => $this->logic->sweaty ? 'Plunger slipped and broke.....' : 'Flushing <em>again....</em>',
            $this->logic->flooding => 'Flooding.......',

        };

        $this->logic->flooding && $this->end = $this->setEndString('<br>... And lost your security deposit.');

        return $words;

    }

    private function milestone5(): string {

        $words = match(true){

            $this->logic->drowning => 'Drowning........',
            $this->logic->verywet => 'Assessing water damage....',
            $this->logic->sweatycry => $this->logic->clogged ? 'Swearing....' : 'Sobbing.....',
            $this->logic->cried => 'Crying again.....',
            default => $this->logic->sweatyclog ? 'Removing splinters.......' : 'Cleaning up......',

        };

        $this->logic->drowning && $this->end = $this->setEndString('<br>... And then died.');

        return $words;

    }

    private function milestone6(): string {

        $words = match(true){

            $this->logic->wetloud => 'Police broke in, no longer drowning.......',
            $this->logic->drowning => '.... No longer drowning.',
            default => 'Experiencing dietary remorse......',

        };

        $this->logic->wetloud && $this->end = $this->setEndString('<br>... And your neighbors want you to move.');

        return $words;

    }

    private function milestone7(): string {

        $words = match(true){

            $this->logic->drowning => $this->logic->screamed ? 'Being fined for screaming earlier.....' : '........',
            $this->logic->clogged, 
            $this->logic->flooding => 'Calling a plumber.....',
            default => 'Reconsidering dairy......',

        };

        return $words;
        
    }

    private function prepString(string $string): string {
        
        $finished = ($string !== '') ? "<li class=\"poop-message\"><p>{$string}</p></li>\n" : '';

        return $finished;
        
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

    private function setEndString(string $end): string {

        $s = $this->logic->poops === 1 ? '' : 's';
        $formatted = \number_format($this->logic->poops);

        return "<div class=\"final\"><p>You Pooped: {$formatted} Time{$s}! {$end}<br><button id=\"poop-again\">Poop Again?</button></p></div>";

    }

    private function preparePoopArr(): void {

        $pooparr[] = '<div class="poop-start"><p>Pooping...</p></div>'."\n";

        for($i = 0; $i < $this->logic->poops; $i++){
            if($i < 25 || ($i % 25) === 0){
                $pooparr[] = match(true){
                    $i === 0,
                    $i === 90000 =>  '<li>poop</li>'."\n",
                    ($i % 10000) === 0 => $this->prepString($this->event[$i]),
                    default => '<li>poop</li>'."\n",
                };
            }
        }

        $this->finishPoopArr($pooparr);

    }

    private function finishPoopArr(array $pooparr): void {

        $pooparr[] = $this->end;
        $pooparr = \array_values(
            \array_filter($pooparr)
        );

        echo \json_encode($pooparr);

    }

}
