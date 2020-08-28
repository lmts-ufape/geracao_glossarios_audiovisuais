(function () {


    
    var totalPlayerAudio, idElement;
    
    // cria um novo player de audio
    function playerAudio(playerID) {

        // Elementos do player
        var videoTarget, playerElem, playerAudio, jlPlayerLegends, playerAudioLoader, playerAudioControls, volTarget, rangeVol, sliderVol, sliderDrag, rangeSeeker, progressBuffer, progressAudio, currentTimeTooltip, trackCaption, activeCaption, cuesTrack, cuesText, activityMouseFull, activityMouseTime, systemTime, isTouch, elementFullScreen, played;

        // Ações da barra de controles
        var playerBtnPlay, playerProgress, playerTotalTime, playerBtnVol, playerSliderVol, playerBtnCC, jlPlayerBtnScreen, playerBtnPlayCenter;

        // Contents
        var svgIcos, icoVol, jlPlayerContent;

        //gif e png para troca

        isTouch = ('ontouchstart' in document.documentElement === true);
        sliderDrag = false;
        cuesText = '';
        activeCaption = 'disabled';
        activityMouseFull = false;
        played = false;

        //icones
        svgIcos = {
            play: '<svg viewBox="0 0 12 18"><path d="M13.6,8.1L1.9,0.2C1.1-0.3,0,0.2,0,1.1v15.7c0,0.9,1.1,1.5,1.9,0.9l11.7-7.9C14.1,9.4,14.1,8.6,13.6,8.1L13.6,8.1z"/></svg><span class="player-audio-tooltip">Iniciar</span>',
            pause: '<svg viewBox="0 0 18 18"><path d="M6 1H3c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h3c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1zM12 1c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h3c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1h-3z"/></svg><span class="player-audio-tooltip">Pausar</span>',
            restart: '<svg viewBox="0 0 18 18"><path d="M9.7 1.2l.7 6.4 2.1-2.1c1.9 1.9 1.9 5.1 0 7-.9 1-2.2 1.5-3.5 1.5-1.3 0-2.6-.5-3.5-1.5-1.9-1.9-1.9-5.1 0-7 .6-.6 1.4-1.1 2.3-1.3l-.6-1.9C6 2.6 4.9 3.2 4 4.1 1.3 6.8 1.3 11.2 4 14c1.3 1.3 3.1 2 4.9 2 1.9 0 3.6-.7 4.9-2 2.7-2.7 2.7-7.1 0-9.9L16 1.9l-6.3-.7z"/></svg><span class="player-audio-tooltip">Reiniciar</span>',
            playc: '<svg viewBox="0 0 12 18"><path d="M13.6,8.1L1.9,0.2C1.1-0.3,0,0.2,0,1.1v15.7c0,0.9,1.1,1.5,1.9,0.9l11.7-7.9C14.1,9.4,14.1,8.6,13.6,8.1L13.6,8.1z"/></svg>',
            pausec: '<svg viewBox="0 0 18 18"><path d="M6 1H3c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h3c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1zM12 1c-.6 0-1 .4-1 1v14c0 .6.4 1 1 1h3c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1h-3z"/></svg>',
            volhigh: '<svg viewBox="0 0 18 18"><path d="M15.6 3.3c-.4-.4-1-.4-1.4 0-.4.4-.4 1 0 1.4C15.4 5.9 16 7.4 16 9c0 1.6-.6 3.1-1.8 4.3-.4.4-.4 1 0 1.4.2.2.5.3.7.3.3 0 .5-.1.7-.3C17.1 13.2 18 11.2 18 9s-.9-4.2-2.4-5.7z"></path><path d="M11.282 5.282a.909.909 0 0 0 0 1.316c.735.735.995 1.458.995 2.402 0 .936-.425 1.917-.995 2.487a.909.909 0 0 0 0 1.316c.145.145.636.262 1.018.156a.725.725 0 0 0 .298-.156C13.773 11.733 14.13 10.16 14.13 9c0-.17-.002-.34-.011-.51-.053-.992-.319-2.005-1.522-3.208a.909.909 0 0 0-1.316 0zM3.786 6.008H.714C.286 6.008 0 6.31 0 6.76v4.512c0 .452.286.752.714.752h3.072l4.071 3.858c.5.3 1.143 0 1.143-.602V2.752c0-.601-.643-.977-1.143-.601L3.786 6.008z"></path></svg><span class="player-audio-tooltip">Desativar</span>',
            vollow: '<svg viewBox="0 0 18 18"></path><path d="M11.282 5.282a.909.909 0 0 0 0 1.316c.735.735.995 1.458.995 2.402 0 .936-.425 1.917-.995 2.487a.909.909 0 0 0 0 1.316c.145.145.636.262 1.018.156a.725.725 0 0 0 .298-.156C13.773 11.733 14.13 10.16 14.13 9c0-.17-.002-.34-.011-.51-.053-.992-.319-2.005-1.522-3.208a.909.909 0 0 0-1.316 0zM3.786 6.008H.714C.286 6.008 0 6.31 0 6.76v4.512c0 .452.286.752.714.752h3.072l4.071 3.858c.5.3 1.143 0 1.143-.602V2.752c0-.601-.643-.977-1.143-.601L3.786 6.008z"></path></svg><span class="player-audio-tooltip">Desativar</span>',
            volmute: '<svg viewBox="0 0 18 18"><path d="M12.4 12.5l2.1-2.1 2.1 2.1 1.4-1.4L15.9 9 18 6.9l-1.4-1.4-2.1 2.1-2.1-2.1L11 6.9 13.1 9 11 11.1zM3.786 6.008H.714C.286 6.008 0 6.31 0 6.76v4.512c0 .452.286.752.714.752h3.072l4.071 3.858c.5.3 1.143 0 1.143-.602V2.752c0-.601-.643-.977-1.143-.601L3.786 6.008z"/></svg><span class="player-audio-tooltip">Ativar</span>',
            cc: '<svg viewBox="0 0 18 18"><path d="M1 1c-.6 0-1 .4-1 1v11c0 .6.4 1 1 1h4.6l2.7 2.7c.2.2.4.3.7.3.3 0 .5-.1.7-.3l2.7-2.7H17c.6 0 1-.4 1-1V2c0-.6-.4-1-1-1H1zm4.52 10.15c1.99 0 3.01-1.32 3.28-2.41l-1.29-.39c-.19.66-.78 1.45-1.99 1.45-1.14 0-2.2-.83-2.2-2.34 0-1.61 1.12-2.37 2.18-2.37 1.23 0 1.78.75 1.95 1.43l1.3-.41C8.47 4.96 7.46 3.76 5.5 3.76c-1.9 0-3.61 1.44-3.61 3.7 0 2.26 1.65 3.69 3.63 3.69zm7.57 0c1.99 0 3.01-1.32 3.28-2.41l-1.29-.39c-.19.66-.78 1.45-1.99 1.45-1.14 0-2.2-.83-2.2-2.34 0-1.61 1.12-2.37 2.18-2.37 1.23 0 1.78.75 1.95 1.43l1.3-.41c-.28-1.15-1.29-2.35-3.25-2.35-1.9 0-3.61 1.44-3.61 3.7 0 2.26 1.65 3.69 3.63 3.69z" fill-rule="evenodd"/></svg><span class="player-audio-tooltip">Legenda</span>',
            fullscreen: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 64 50" width="64pt" height="50pt"><defs><clipPath id="_clipPath_lNW43MHBcI9NDve1qgo0BFxv1CWFQvVD"><rect width="64" height="50"/></clipPath></defs><g clip-path="url(#_clipPath_lNW43MHBcI9NDve1qgo0BFxv1CWFQvVD)"><rect x="0" y="0" width="6" height="50" transform="matrix(1,0,0,1,0,0)" fill="rgb(255,255,255)"/><rect x="58" y="0" width="6" height="50" transform="matrix(1,0,0,1,0,0)" fill="rgb(255,255,255)"/><rect x="29.005" y="-28.878" width="6" height="63.989" transform="matrix(-0.004,1,-1,-0.004,35.238,-28.877)" fill="rgb(255,255,255)"/><rect x="29.005" y="15.889" width="6" height="63.989" transform="matrix(-0.004,1,-1,-0.004,80.005,16.053)" fill="rgb(255,255,255)"/></g></svg><span class="player-audio-tooltip">Tela Cheia</span>',
            restore: '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 64 50" width="64pt" height="50pt"><defs><clipPath id="_clipPath_JksV4HF9M4J5RgpvBLXOOh65hvaFFdSx"><rect width="64" height="50"/></clipPath></defs><g clip-path="url(#_clipPath_JksV4HF9M4J5RgpvBLXOOh65hvaFFdSx)"><rect x="0" y="0" width="9" height="50" transform="matrix(1,0,0,1,0,0)" fill="rgb(255,255,255)"/><rect x="54.988" y="0" width="9" height="50" transform="matrix(1,0,0,1,0,0)" fill="rgb(255,255,255)"/><rect x="27.558" y="-27.436" width="8.884" height="63.989" transform="matrix(-0.004,1,-1,-0.004,36.674,-27.425)" fill="rgb(255,255,255)"/><rect x="27.536" y="13.447" width="8.884" height="63.989" transform="matrix(-0.004,1,-1,-0.004,77.536,13.629)" fill="rgb(255,255,255)"/></g></svg><span class="player-audio-tooltip">Restaurar</span>'
        };

        playerAudioContent = '<div class="player-audio-loader"><div class="player-audio-loader-box"><div class="player-audio-gif"><div class="player-audio-spinner"> <div class="player-audio-bounce1"></div><div class="player-audio-bounce2"></div><div class="player-audio-bounce3"></div></div></div></div></div><div class="btns-audio-centrais"><button type="button" class="quality-hd" onclick="mudarAudioParaHD(this)">Ouvir em Alta Qualidade (HD)</button><button type="button" class="quality-sd" onclick="mudarAudioParaSD(this)">Ouvir em Baixa Qualidade (SD)</button></div><div class="player-audio-controls player-audio-controls-show"><button type="button" class="player-audio-play" style="left: 10px;"><svg viewBox="0 0 18 18"></svg><span class="player-audio-tooltip">Iniciar</span></button><button type="button" class="player-audio-vol"><svg viewBox="0 0 18 18"></svg><span class="player-audio-tooltip">Desativar</span></button><div class="player-audio-volume"><input class="player-audio-rangevol" type="range" min="0" max="1" value="1" step="0.01"><div class="player-audio-progress"><span class="player-audio-setvolume" style="width: 100%;"></span></div></div>&nbsp;&nbsp;&nbsp;<div class="player-audio-presentation"><input class="player-audio-rangeprog" type="range" min="0" max="100" step="0.1" value="0"><div class="player-audio-progress"><span class="player-audio-pbuffer"></span><span class="player-audio-pplayed"></span></div><span class="player-audio-tooltip">00:00</span></div><span class="player-audio-time">00:00</span></div></div>'

        function construct() {
            // Cria div container do player
            audioTarget = get(document, playerID);
            audioTarget.insertAdjacentHTML('afterend', '<div id="' +  playerID + '"></div>');
            document.getElementById(playerID).remove();
            playerElem = get(document,  playerID);
            audioTarget.removeAttribute('id');
            audioTarget.removeAttribute('class');
            playerElem.appendChild(audioTarget);
            playerElem.setAttribute('class', 'player-audio player-audio-cursor-show');
            playerElem.innerHTML += playerAudioContent;

            /**
             * Elementos do player
             */

            // Elemento vídeo do player
            playerAudio = get(playerElem, 'audio', 'tag');
            // Loader
            playerAudioLoader = get(playerElem, 'player-audio-loader', 'class');

            // Controls
            playerAudioControls = get(playerElem, 'player-audio-controls', 'class');

            // Botão Play Pause e Restart
            playerBtnPlay = get(playerAudioControls, 'player-audio-play', 'class');
            playerBtnPlay.innerHTML = svgIcos.play;

            // Progress
            playerProgress = get(playerAudioControls, 'player-audio-presentation', 'class');

            // Range Seeker
            rangeSeeker = get(playerProgress, 'input', 'tag');

            // Buffer
            progressBuffer = get(playerProgress, 'player-audio-pbuffer', 'class');

            // Tooltip progress
            currentTimeTooltip = get(playerProgress, 'player-audio-tooltip', 'class');

            // Progress
            progressAudio = get(playerProgress, 'player-audio-pplayed', 'class');

            // Time total
            playerTotalTime = get(playerAudioControls, 'player-audio-time', 'class');

            // Volume button
            playerBtnVol = get(playerAudioControls, 'player-audio-vol', 'class');
            playerBtnVol.innerHTML = svgIcos.volhigh;
            icoVol = 'volhigh';

            // Volume Controls
            playerSliderVol = get(playerAudioControls, 'player-audio-volume', 'class');

            // Range volume
            rangeVol = get(playerSliderVol, 'input', 'tag');

            // Slider Volume
            sliderVol = get(playerSliderVol, 'player-audio-setvolume', 'class');

            // Eventos de seeker
            handler(playerProgress, 'mousedown', startDrag, !0);
            handler(playerSliderVol, 'mousedown', startDrag, !0);

            // eventos de audio
            handler(playerBtnVol, 'click', muteVideo, !0);
            handler(playerSliderVol, 'mousedown click mousewheel touchstart touchmove touchend', setVolume, !0);

            // Eventos do document
            handler(document, 'mouseup', startDrag, !0);
            handler(document, 'webkitfullscreenchange mozfullscreenchange fullscreenchange', checkFullscren, !0);

            // Eventos do vídeo
            handler(playerAudio, 'canplay', canplay, !0);
            handler(playerAudio, 'timeupdate', updateTimer, !0);
            handler(playerAudio, 'waiting canplay playing play loadstart seeked', audioLoader, !0);
            handler(playerAudio, 'ended', restartVideo, !0);

            autoCorretor();

            // Dispara se ouver erro
            handler(playerAudio, 'error', audioError, !0);

            // Atividade do mouse
            handler(playerElem, 'mousemove', checkMouseActivity, !0);
            activityMouseFull = false;

            handler(playerAudio, 'progress', progressBuffering, !0);
        }

        // Verifica a atividade do mouse em fullscreen para esconder a barra de controles
        function checkMouseActivity(evt) {

            if (!activityMouseFull) {
                activityMouseFull = true;
                var e = playerElem.className;
                playerElem.className = e.replace("player-audio-cursor-hidden", "player-audio-cursor-show");
            }

            var d = new Date();
            activityMouseTime = d.getTime();
        }

        function progressBuffering() {

            var d = playerAudio.duration,
                c = playerAudio.currentTime,
                buffer = playerAudio.buffered,
                bufferW = 0;

            if (d > 0) {
                for (var i = 0; i < buffer.length; i++) {
                    if (buffer.start(buffer.length - 1 - i) < c) {
                        progressBuffer.style.width = (buffer.end(buffer.length - 1 - i) / d) * 100 + "%";
                        break;
                    }
                }
            }
        }

        // getElementBy - e = elemento container - a = qual atributo - v = valor do atributo - i = indice
        function get(e, v, a, i) {
            i = !i ? 0 : i;
            switch (a) {
                case 'class':
                    return e["getElementsByClassName"](v)[i];
                    break;
                case 'tag':
                    return e["getElementsByTagName"](v)[i];
                    break;
                default:
                    return e["getElementById"](v);
            }
        }

        // e = Elemento - t = tipos de eventos separados por espaço - f = função chamada - c = capture - r = addEventListener ou removeEventListener
        function handler(e, t, f, r, c) {
            var s = t.split(" ");
            for (var i = 0; i < s.length; i++) {
                e[r ? "addEventListener" : "removeEventListener"](s[i], f, c);
            }
        }

        // Loader do player
        function audioLoader(evt) {
            if (played) {
                if (evt.type == 'waiting' || evt.type == 'loadstart') {
                    playerAudioLoader.style.display = 'block';
                } else {
                    playerAudioLoader.style.display = 'none';
                }
            }
        }

        // Atualiza o time, progress e o buffer do vídeo
        function updateTimer(evt) {

            //Duração total do video
            var h = Math.floor(playerAudio.currentTime / 3600),
                m = Math.floor(playerAudio.currentTime / 60),
                s = Math.floor(((playerAudio.currentTime / 60) % 1) * 60);

            // Usa o metodo convertTimer para setar a duração do vídeo
            playerTotalTime.textContent = convertTimer(h, m, s);


            var pctSeek = (playerAudio.currentTime / playerAudio.duration) * 100;

            if (!sliderDrag) {
                progressAudio.style.width = pctSeek + '%';
                rangeSeeker.value = pctSeek;
            }

            // Sistema de legenda
            if (trackCaption) {
                // Seta modo da legenda para 'hidden' quando for 'showing'
                if (trackCaption.mode == 'showing') {
                    trackCaption.mode = 'hidden';
                    activeCaption = 'hidden';
                }

                // Se a legenda estiver ativada chama metodo de controle de legenda
                if (trackCaption.mode != 'disabled') {
                    cuesControls();
                }

            }


            // Controle de atividade do mouse para esconder o menu
            // var ms = new Date();
            // if (activityMouseFull) {
            //     if (ms.getTime() > (activityMouseTime + 3000)) {
            //         activityMouseFull = false;

            //         var e = playerElem.className;
            //         playerElem.className = e.replace("player-audio-cursor-show", "player-audio-cursor-hidden");
            //     }
            // }
        }


        // Verifica o estado do Fullscreen para trocar do icone do botão e a class jlplayer-video-fullscreen 
        function checkFullscren() {
            var df = document.fullscreenElement || document.mozFullScreenElement || document.webkitFullscreenElement || document.msFullscreenElement;

            var c = jlPlayerElem.className;

            if (!df) {
                jlPlayerElem.className = c.replace('jlplayer-fullscreen-on', 'jlplayer-fullscreen-off');
                jlPlayerBtnScreen.innerHTML = svgIcos.fullscreen;
            } else {
                jlPlayerElem.className = c.replace('jlplayer-fullscreen-off', 'jlplayer-fullscreen-on');
                jlPlayerBtnScreen.innerHTML = svgIcos.restore;
            }
        }

        // Ação de reiniciar o vídeo quando acabar
        function restartVideo(evt) {
            playerAudio.parentElement.parentElement.style.backgroundImage = playerAudio.children[8].value.split(" ")[0];
            playerAudio.parentElement.parentElement.style.backgroundSize = playerAudio.children[8].value.split(" ")[1];
            playerAudio.parentElement.parentElement.style.paddingBottom = playerAudio.children[8].value.split(" ")[2];
            playerAudio.parentElement.children[2].style.display = "flex";
            playerBtnPlay.innerHTML = svgIcos.restart;
            var e = playerElem.className;
            playerElem.className = e.replace("player-audio-cursor-hidden", "player-audio-cursor-show");
            //jlPlayerBtnPlayCenter.innerHTML = svgIcos.playc;
            //jlPlayerBtnPlayCenter.style.display = 'block';
        }

        // Controla o volume apartir do slider
        function setVolume(evt) {

            var value = rangeVol.value,
                clientX = 0,
                ClientRect = playerSliderVol.getBoundingClientRect(),
                position = 0,
                deltaWheel = Math.max(-1, Math.min(1, evt.wheelDelta));

            if (String(evt.type) !== 'touchend') {
                clientX = (String(evt.clientX) !== 'undefined' ? evt.clientX : evt.touches[0].clientX);
                clientX = (clientX - ClientRect.left) / rangeVol.clientWidth;
            }

            // Ações e eventos
            switch (evt.type) {

                case 'touchstart':
                    sliderVol.style.width = (clientX * 100) + '%';
                    break;

                case 'mousemove':
                    if (sliderDrag) {
                        updateVolume();
                    }
                    break;

                case 'mousewheel':
                    rangeVol.value -= (-0.1 * deltaWheel);
                    value = rangeVol.value;
                    updateVolume();

                    break;

                default:
                    updateVolume();
            }

            // Atualizar o sistema de volume
            function updateVolume() {
                if (playerAudio.muted) {
                    playerAudio.muted = false;
                }

                playerAudio.volume = value;
                sliderVol.style.width = (value * 100) + '%';

                volTarget = (playerAudio.volume > 0 ? playerAudio.volume : 1);
                if (playerAudio.volume > 0) {
                    if (playerAudio.volume >= 0.5) {
                        if (icoVol != 'volhigh') {
                            playerBtnVol.innerHTML = svgIcos.volhigh;
                            icoVol = 'volhigh';
                        }

                    } else {
                        if (icoVol != 'vollow') {
                            playerBtnVol.innerHTML = svgIcos.vollow;
                            icoVol = 'vollow';
                        }
                    }
                } else {
                    playerAudio.muted = true;
                    if (icoVol != 'volmute') {
                        playerBtnVol.innerHTML = svgIcos.volmute;
                        icoVol = 'volmute';
                    }
                }
            }
        }

        // Controla o seeker do vídeo apartir do slider
        function setSeeker(evt) {

            var clientX = (String(evt.clientX) !== 'undefined' ? evt.clientX : evt.touches[0].clientX);

            var ClientRect = playerProgress.getBoundingClientRect(),
                value = (clientX - ClientRect.left) / rangeSeeker.clientWidth,
                cH = Math.floor((value * playerAudio.duration) / 3600),
                cM = Math.floor((value * playerAudio.duration) / 60),
                cS = Math.floor((((value * playerAudio.duration) / 60) % 1) * 60);

            currentTimeTooltip.textContent = convertTimer(cH, cM, cS);
            currentTimeTooltip.style.left = (value * 100) + '%';

            switch (evt.type) {
                case 'mousemove':
                    if (sliderDrag) {
                        progressAudio.style.width = (value * 100) + '%';
                        updateSeeker();
                    }
                    break;
                case 'touchmove':
                    progressAudio.style.width = (value * 100) + '%';
                    updateSeeker();
                    break;
                default:
                    updateSeeker();
            }

            // Seta a nova posição do seeker
            function updateSeeker() {
                rangeSeeker.value = (value * 100);
                progressAudio.style.width = (value * 100) + '%';
                playerAudio.currentTime = (value * playerAudio.duration);
            }
        }

        // Controle do botão de volume
        function muteVideo() {
            if (!playerAudio.muted) {
                volTarget = (playerAudio.volume > 0 ? playerAudio.volume : 1);
                playerAudio.muted = true;
                playerAudio.volume = 0;
                playerBtnVol.innerHTML = svgIcos.volmute;
                icoVol = 'volmute';
                rangeVol.value = 0;
                sliderVol.style.width = 0;
            } else {
                playerAudio.muted = false;
                playerAudio.volume = volTarget;
                rangeVol.value = volTarget;
                sliderVol.style.width = (volTarget * 100) + '%';
                if (playerAudio.volume >= 0.5) {
                    playerBtnVol.innerHTML = svgIcos.volhigh;
                    icoVol = 'volhigh';
                } else {
                    playerBtnVol.innerHTML = svgIcos.vollow;
                    icoVol = 'vollow';
                }
            }
        }

        // Libera o arrastar dos inputs range
        function startDrag(evt) {
            if (evt.type == "mousedown") {
                sliderDrag = true;
                if (String(evt.target.className) === 'player-audio-rangevol') {
                    handler(playerSliderVol, 'mousemove', setVolume, !0);
                }
            } else {
                sliderDrag = false;
                playerSliderVol.removeEventListener('mousemove', setVolume);
            }
        }

        // Faz a correção dos elementos obrigatórios
        function autoCorretor() {
            playerElem.setAttribute('oncontextmenu', 'return false');
            playerAudio.controls = false;
            //playerAudio.setAttribute('crossorigin', '');

            /*
            if (!playerAudio.getAttribute('preload')) {
                playerAudio.preload = 'none';
            }*/

            // Remove botão de legenda se não encontrar nenhuma track...
            //if (!playerElem.getElementsByTagName('track')[0]) {
            //    jlPlayerBtnCC.remove();
            //}

            if (playerAudio.preload == 'none') {
                // Eventos de player e pause
                handler(playerBtnPlay, 'click', playAudio, !0);
                //handler(jlPlayerBtnPlayCenter, 'click', playVideo, !0);
                handler(playerAudio, 'click', playAudio, !0);
                if (isTouch) {
                    handler(playerAudio, 'click', playAudio, !1);
                }
            }
        }

        // Converte o tempo e retorna no formato de hh:mm:ss
        function convertTimer(hours, minutes, seconds) {
            hours = (hours < 10 && hours > 0 ? '0' + hours + ":" : '');
            minutes = ((minutes < 10) ? '0' + minutes : minutes);
            minutes = ((minutes > 59) ? (minutes - (Math.floor(minutes / 60) * 60)) : minutes);
            seconds = ((seconds < 10) ? '0' + seconds : seconds);
            return String(hours) + String(minutes) + ':' + String(seconds);
        }

        // Chamado quando ouve erro no vídeo
        function audioError() {
            playerTotalTime.textContent = '00:00';
            currentTimeTooltip.textContent = '00:00';
        }

        // Ações de play e pause do vídeo
        function playAudio(evt) {

            var e = String(evt.target.tagName);
            if (isTouch && e.toLowerCase() === 'audio') {
                return false;
            }

            if (playerAudio.played.length != 0) {
                if (playerAudio.paused) {
                    played = true;
                    playerAudio.play();
                    playerAudio.parentElement.parentElement.style.backgroundImage = playerAudio.children[7].value.split(" ")[0];
                    playerAudio.parentElement.parentElement.style.backgroundSize = playerAudio.children[7].value.split(" ")[1];
                    playerAudio.parentElement.parentElement.style.paddingBottom = playerAudio.children[7].value.split(" ")[2];
                    playerAudio.parentElement.children[2].style.display = "none";
                    playerBtnPlay.innerHTML = svgIcos.pause;
                    //jlPlayerBtnPlayCenter.innerHTML = svgIcos.pausec;
                    if (!isTouch) {
                        //jlPlayerBtnPlayCenter.style.display = 'none';
                    }
                } else {
                    played = false;
                    playerAudio.pause();
                    playerAudio.parentElement.parentElement.style.backgroundImage = playerAudio.children[8].value.split(" ")[0];
                    playerAudio.parentElement.parentElement.style.backgroundSize = playerAudio.children[8].value.split(" ")[1];
                    playerAudio.parentElement.parentElement.style.paddingBottom = playerAudio.children[8].value.split(" ")[2];
                    playerAudio.parentElement.children[2].style.display = "flex";
                    playerBtnPlay.innerHTML = svgIcos.play;
                    //jlPlayerBtnPlayCenter.innerHTML = svgIcos.playc;
                    if (!isTouch) {
                        //jlPlayerBtnPlayCenter.style.display = 'block';
                    }

                }
            } else {
                played = true;
                playerAudio.play();
                playerAudio.parentElement.parentElement.style.backgroundImage = playerAudio.children[7].value.split(" ")[0];
                playerAudio.parentElement.parentElement.style.backgroundSize = playerAudio.children[7].value.split(" ")[1];
                playerAudio.parentElement.parentElement.style.paddingBottom = playerAudio.children[7].value.split(" ")[2];
                playerAudio.parentElement.children[2].style.display = "none";
                playerBtnPlay.innerHTML = svgIcos.pause;
                //jlPlayerBtnPlayCenter.innerHTML = svgIcos.pausec;
                if (!isTouch) {
                    //jlPlayerBtnPlayCenter.style.display = 'none';
                }
            }
        }

        // Chamado quando o vídeo pode ser reproduzido
        function canplay(evt) {

            played = true;

            //Duração total do video
            var h = Math.floor(playerAudio.duration / 3600),
                m = Math.floor(playerAudio.duration / 60),
                s = Math.floor(((playerAudio.duration / 60) % 1) * 60);

            // Usa o metodo convertTimer para setar a duração do vídeo
            playerTotalTime.textContent = convertTimer(h, m, s);

            // CurrentTime
            var cH = Math.floor(playerAudio.currentTime / 3600),
                cM = Math.floor(playerAudio.currentTime / 60),
                cS = Math.floor(((playerAudio.currentTime / 60) % 1) * 60);


            // Usa o metodo convertTimer para setar a o tempo de andamento do vídeo
            currentTimeTooltip.textContent = convertTimer(cH, cM, cS);

            // Eventos de seeker
            handler(playerProgress, 'mousedown mouseup mousemove touchstart touchmove', setSeeker, !0);

            // Faz a leitura do track da primeira legenda
            trackCaption = playerAudio.textTracks[0];

            // Verifica se existra track de legenda
            if (trackCaption) {
                trackCaption.mode = activeCaption;
            }


            // Eventos de player e pause
            handler(playerBtnPlay, 'click', playAudio, !0);
            //handler(jlPlayerBtnPlayCenter, 'click', playAudio, !0);
            handler(playerAudio, 'click touchstart', playAudio, !0);

            // Remove evento click se existir touch
            if (isTouch) {
                handler(playerAudio, 'click', playAudio, !1);
            }

        }

        // Atualiza o texto da legenda quando disponivel
        function cuesControls() {

            cuesTrack = trackCaption.activeCues;

            if (cuesTrack) {
                if (cuesTrack.length > 0) {
                    if (cuesText !== cuesTrack[0].getCueAsHTML().textContent)
                        cuesText = cuesTrack[0].getCueAsHTML().textContent;
                    jlPlayerLegends.innerHTML = '<span>' + cuesText + '</span>';
                } else {
                    if (cuesText !== '') {
                        cuesText = '';
                        jlPlayerLegends.innerHTML = '<span></span>';
                    }
                }
            }
        }
        

        // Chama o metodo de construção
        construct();
    }

    totalPlayerAudio = document.getElementsByClassName('player-audio').length;
    if (totalPlayerAudio > 0) {

        for (var i = 0; i < totalPlayerAudio; i++) {
            idElement = 'player-audio-' + Math.floor(Math.random() * 100000000);
            document.getElementsByClassName('player-audio')[i].id = idElement;
            new playerAudio(idElement);
        }
    }
})();