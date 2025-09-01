<?php
header('Allow: POST, HEAD');
header('Cross-Origin-Resource-Policy: same-origin');
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    
    header('HTTP/1.1 200 OK');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Cache-Control: no-cache');
    header('Pragma: no-cache');
    header('X-Toilet-Status: destroyed');
    header('X-Pants-Status: not pooped');
    
    function echoRandString($string){
    
        $num = mt_rand(1, 10);
        
        if(($num % 2) === 0){
            return '<li class="poop-message"><p>'. $string .'</p></li>'."\n";
        }
        
        return '';
        
    }
    
    function echoString($string){
        
        return '<li class="poop-message"><p>'. $string .'</p></li>'."\n";
        
    }
    
    function echoDivString($string){
        
        return '<div class="final"><p>'. $string .'</p></div>'."\n";
        
    }

    $poops = mt_rand(25, 90000);
    $array = [0 => '<div class="poop-start"><p>Pooping...</p></div>'."\n"];
    $string = '';
    $dead = '';
    $clogged = false;
    $flooding = false;
    $drowning = false;
    
    if($poops < 10000){
        $dead = "<br>... Very normal\n!";
    }
    
    if($poops < 5000){
        $dead = "<br>... Almost flushable!\n";
    }
    
    if($poops === 69){
        $dead = "<br>... Haha, gross.\n";
    }
    
    for($i = 1; $i < $poops; $i++){
        
        switch($i){
            case 10000:
                $screamed = false;
                $sweating = false;
                $scream = echoRandString('Screaming.....');
                if(!empty($scream)){
                    $screamed = true;
                    $string .= $scream;
                }else{
                    $sweat = echoRandString('Sweating.....');
                    if(!empty($sweat)){
                        $sweating = true;
                        $string .= $sweat;
                    }
                }
            break;
            case 20000:
                $cried = false;
                $cry = echoRandString('Crying........');
                if(!empty($cry)){
                    $cried = true;
                    $string .= $cry;
                }
            break;
            case 30000:
                $string .= echoString('Flushing.........');
            break;
            case 40000:
                $clog = echoRandString('Unclogging.......');
                if(!empty($clog)){
                    $clogged = true;
                    $string .= $clog;
                }else{
                    $string .= echoString('Flushing again......');
                }
            break;
            case 50000:
                if($clogged === true){
                    $flood = echoRandString('Flooding.......');
                    if(!empty($flood)){
                        $flooding = true;
                        $dead = '<br>... And lost your security deposit.';
                        $string .= $flood;
                    }else{
                        if($sweating){
                            $string .= echoString('Plunger slipped, broke.....');
                        }else{
                            $string .= echoString('Flushing <em>again....</em>');
                        }
                    }
                }else{
                    $string .= echoString('Flushing a third time...');
                }
            break;
            case 60000:
                if($clogged === true && $flooding === true){
                    $rand = mt_rand(1, 10);
                    if(($rand % 2) === 0){
                        $drowning = true;
                        $dead = '<br>... And then died.';
                        $string .= echoString('Drowning........');
                    }else{
                        $string .= echoString('Assessing water damage....');
                    }
                }else{
                    if($cried){
                        if($clogged && !$sweating){
                            $string .= echoString('Sobbing.....');
                        }elseif($sweating){
                            $string .= echoString('Swearing....');
                        }else{
                            $string .= echoString('Crying again.....'); 
                        }
                    }else{
                        if($sweating && $clogged){
                            $string .= echoString('Removing splinters.......');
                        }else{
                            $string .= echoString('Cleaning up......');
                        }
                    }
                }
            break;
            case 70000:
                if(!$drowning){
                    $string .= echoString('Experiencing dietary remorse......');
                }else{
                    if($screamed){
                        $dead = '<br>... And your neighbors want you to move.';
                        $string .= echoString('Police broke in, no longer drowning.......');
                    }else{
                        $string .= echoString('.... No longer drowning.');
                    }
                }
            break;
            case 80000:
                if($drowning){
                    if($screamed){
                        $string .= echoString('Being fined for screaming earlier.....');
                    }else{
                        $string .= echoString('........');
                    }
                }else{
                    if($clogged || $flooding){
                        $string .= echoString('Calling a plumber.....');
                    }else{
                        $string .= echoString('Reconsidering dairy......');
                    }
                }
            break;
            default:
        }
        
        if($i < 25 || ($i % 25) === 0){
            if(empty($string)){
                $string .= '<li>poop</li>'."\n";
                $array += [$i => $string];
            }else{
                $array += [$i => $string];
            }
            
            $string = '';
            
        }
        
    }
    
    if($poops > 65000 && empty($dead)){
        $dead = '<br>... See a doctor!';
    }
    
    $string .= echoDivString('You Pooped: '. number_format($i) .' Times!'. $dead . '<br><button id="poop-again">Poop Again?</button>');
    $array += [$i+1 => $string];
    
    $array = array_filter($array);
    $array = array_values($array);
    
    echo json_encode($array);
}else{
    header("HTTP/1.1 418 I'm a teapot");
    header('X-Pants-Status: pooped');
    header('X-Toilet-Status: this is a teapot');
    header('Content-Type: text/plain;charset=UTF-8');
    echo 'oops that\'s a teapot';
}