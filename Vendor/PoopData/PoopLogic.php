<?php
declare(strict_types=1);
namespace PoopData;

class PoopLogic {

            public readonly bool $clogged;
            public readonly bool $flooding;
            public readonly bool $drowning;
            public readonly bool $screamed;
            public readonly bool $sweaty;
            public readonly bool $cried;
            public readonly bool $sweatycry;
            public readonly bool $sweatyclog;
            public readonly bool $verywet;
            public readonly bool $wetloud;
            public readonly int $poops;
            public array $milestones;

        public function __construct(){

            $this->setPoopAmount();
            $this->setMilestones();

        }

    private function setPoopPhase1(): void {

        $this->screamed = self::rollForTrue();
        $this->sweaty = !$this->screamed ? self::rollForTrue() : false;

    }

    private function setPoopPhase2(): void {

        $this->cried = self::rollForTrue();

    }

    private function setPoopPhase3(): void {

        $this->clogged = self::rollForTrue();

    }

    private function setPoopPhase4(): void {

        $this->flooding = $this->clogged ? self::rollForTrue() : false;

    }

    private function setPoopPhase5(): void {

        $this->drowning = $this->flooding ? self::rollForTrue() : false;
        $this->setCombos();

    }

    private function setCombos(): void {

        $this->verywet = $this->flooding && !$this->drowning;
        $this->sweatycry = $this->cried && $this->sweaty;
        $this->sweatyclog = $this->sweaty && $this->clogged;
        $this->wetloud = $this->drowning && $this->screamed;

    }

    private static function rollForTrue(): bool {

        $bool = \mt_rand(0, 1) === 1;

        return $bool;

    }

    private function setPoopAmount(): void {

        $this->poops = \mt_rand(1, 90000);
        
    }

    private function setMilestones(): void {

        $poops = 10000;
        $i = 1;

        while($this->poops >= $poops){
            $this->preparePoopEvents($poops, $i);
        };

    }

    private function preparePoopEvents(int &$poops, int &$i): void {

        if($i <= 5){
            $function = "setPoopPhase{$i}";
            $this->{$function}();
            $i++;
        }
        
        $this->milestones[] = $poops;
        $poops += 10000;

    }

}
