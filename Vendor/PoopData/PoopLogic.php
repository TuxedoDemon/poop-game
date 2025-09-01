<?php
declare(strict_types=1);
namespace PoopData;

class PoopLogic {

            public bool $clogged;
            public bool $flooding;
            public bool $drowning;
            public bool $screamed;
            public bool $sweaty;
            public bool $cried;
            public int $poops;
            public array $milestones = [];

        public function __construct(){

            $this->setPoopAmount();
            $this->setMilestones();

        }

    private function setPoopPhase1() {

        $this->screamed = self::rollForTrue();
        $this->sweaty = !$this->screamed ? self::rollForTrue() : false;

    }

    private function setPoopPhase2() {

        $this->cried = self::rollForTrue();

    }

    private function setPoopPhase3() {

        $this->clogged = self::rollForTrue();

    }

    private function setPoopPhase4(){

        $this->flooding = $this->clogged ? self::rollForTrue() : false;

    }

    private function setPoopPhase5(){

        $this->drowning = $this->flooding ? self::rollForTrue() : false;

    }

    public function rollForTrue(): bool {

        $bool = \mt_rand(0, 1) === 1;

        return $bool;

    }

    private function setPoopAmount(){

        $this->poops = \mt_rand(1, 90000);
        
        for($i = 1; $i <= 5; $i++){
            $function = "setPoopPhase{$i}";
            $this->{$function}();
        }
        
    }

    private function setMilestones(){

        $poops = 10000;

        while($this->poops >= $poops){
            $this->milestones[] = $poops;
            $poops += 10000;
        };


    }

}
