'use strict';

const HighScore = function () {

    const getPoop = async () => {
    
        const poop = `${window.location.origin}/poop-start.php`;
        
        try{
            const response = await fetch(poop, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Accept-Charset': 'UTF-8',
                },
            }).then((response) => {
                if(!response.ok){
                    throw new Error(`Response status: ${response.status}`);
                }else{
                    return response;
                }
            });
            return response.json();
        }catch(error){
            console.error(error.message);
        }
        
    }

    const musicForSomeReason = (command, fartingAround) => {
        
        switch(command){
            case 'play':
                fartingAround.play();
                fartingAround.loop = true;
                fartingAround.volume = 0.35;
            break;
            case 'pause':
                fartingAround.pause();
                fartingAround.load();
            break;
            default:
        }
        
    }

    const startPooping = (e, callback) => {
        
        e.target.remove();
        const poop = getPoop();
            
        callback(poop);
        
    }

    const poopAgain = (final, poopagain, fartingAround) => {
        
        if(poopagain){
            musicForSomeReason('pause', fartingAround);
            poopagain.addEventListener('click', (e) => {
                if(final.innerHTML.includes('And then died.')){
                    e.target.remove();
                    
                    const no = document.createElement('div');
                    no.classList.add('poop-message');
                    no.style.cssText = `z-index: 250;`;
                    no.innerHTML = `<p>You died in a tragic toilet accident!\n
                    <br>\n
                    You can't poop anymore!</p>\n`;
                    
                    const poopmessages = document.getElementById('poopmessages');
                    poopmessages.append(no);
                    
                    const skulls = document.getElementById('poop-list').querySelectorAll('li');
                    skulls.forEach((skull) => {
                        skull.innerHTML = "&#128128;";
                        skull.style.cssText = `font-size: 1.75rem;`;
                    });
                }else{
                    document.body.innerHTML = null;
                    handlePoop(e);
                }
            });
        }
        
    }

    const handlePoopStart = (fartingAround, messageArea, json) => {
        
        musicForSomeReason('play', fartingAround);
        
        if(!messageArea){
            messageArea = document.createElement('div');
            messageArea.id = 'poopmessages';
            document.body.prepend(messageArea);
        }
        
        messageArea.innerHTML += json[0];
        
        const list = document.createElement('ul');
        list.id = 'poop-list';
        document.body.append(list);
        
    }

    const handleMostPoops = (json, i, zindex, messageArea, interval, fartingAround, limit) => {

        if(json[i].includes('poop-message')){
            const newDiv = document.createElement('div');
            newDiv.classList.add('poop-message');
            newDiv.innerHTML = json[i];
            
            const words = newDiv.children[0].innerHTML;
            newDiv.innerHTML = words;
            newDiv.style.cssText = `z-index: ${zindex};`;
            
            messageArea = document.getElementById('poopmessages');
            messageArea.append(newDiv);
        }else{
            if(limit !== undefined){
                if(i < limit){
                    const plist = document.getElementById('poop-list');
                    plist.innerHTML += json[i];
                }else{
                    clearInterval(interval);
                    populatePoop(25, messageArea, fartingAround, json, i, zindex);
                }
            }else{
                json[i] = null;
            }
        }
        
    }

    const handleFinalPoop = (json, i, fartingAround) => {
        
        let toot;
                
        if(!toot){
            toot = new Audio('/sound/fart-83471.wav');
        }
        
        let last = document.createElement('div');
        last.innerHTML = json[i];
        last.classList.add('final');
        
        let text = last.children[0].innerHTML;
        last.innerHTML = `${text}`;
        
        const poopmessages = document.getElementById('poopmessages');
        poopmessages.append(last);
        
        const poopagain = document.getElementById('poop-again'),
        final = document.querySelector('.final');
        
        toot.play();
        toot.volume = 0.35;
        poopAgain(final, poopagain, fartingAround);
        
    }

    const populatePoop = (speed, messageArea, fartingAround, json, i, zindex, limit) => {
        
        const interval = setInterval(() => {
            
            switch(i){
                case json.length - 1:
                    clearInterval(interval);
                    handleFinalPoop(json, i, fartingAround);
                break;
                case 0:
                    handlePoopStart(fartingAround, messageArea, json);
                break;
                default:
                    if(json[i].includes('poop-message')){
                        zindex++;
                    }
                    handleMostPoops(json, i, zindex, messageArea, interval, fartingAround, limit);
            }

            i++;
            
        }, speed);
        
    }

    const handlePoop = (e) => {
        
        let fartingAround;
        const credits = document.createElement('aside');
        credits.classList.add('credits');
        credits.innerHTML = `Song: <a target="_blank" title="incompetech.com" href="https://incompetech.com">"Farting Around" by Kevin MacLeod</a>\n
        <br>Licensed under: <a target="_blank" title="creativecommons.org" href="http://creativecommons.org/licenses/by/4.0/">Creative Commons: By Attribution 4.0 International</a>\n
        <br>A small edit was done for a "clean" song loop.\n`;
        document.body.append(credits);
        
        if(!fartingAround){
            fartingAround = new Audio('/sound/farting-around-loop.wav');
        }
        
        startPooping(e, (poop) => {
            poop.then((json) => {
                let messageArea,
                i = 0,
                zindex = 0,
                limit = 1500;
                
                if(json !== undefined){
                    if(i < limit){
                        populatePoop(10, messageArea, fartingAround, json, i, zindex, limit);
                    }
                }
            });
        });

    }

    return {handlePoop};

}();

const start = document.getElementById('start');

if(start){
    start.addEventListener('click', (e) => {
        HighScore.handlePoop(e);
    });
}
