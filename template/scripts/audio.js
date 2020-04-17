window.addEventListener('load', () => {
  
  if (document.getElementById('audio')) {
    const music = document.getElementById('audio');
    const progressLine = document.querySelector('.progress-line');
    const timeLine = document.querySelector('.time-line');
    const { duration } = music;
    const audioDot = document.querySelector('.audio-dot');
    const timeLineWidth = timeLine.offsetWidth;
    const currentTimeWrapper = document.querySelector('.audio-current-time');
    const buttonPlay = document.querySelector('.audio-play');

    const formatTime = seconds => {
      seconds = parseInt(seconds);

      const hours = parseInt(seconds / 3600);
      const minutes = parseInt((seconds -= hours * 3600) / 60);
      seconds -= minutes * 60;
      return {minutes, seconds}
    }

    const playStart = () => {
      
      if (buttonPlay.classList.contains('playing')) {
        buttonPlay.classList.remove('playing');
        buttonPlay.classList.add('pause');
        music.pause();
      }
      else if (buttonPlay.classList.contains('pause')) {
        buttonPlay.classList.remove('pause');
        buttonPlay.classList.add('playing');
        music.play(); 
      }
    }

    const timeUpdate = () => {
      const progressWidth = timeLineWidth * (music.currentTime / duration);
      const {minutes, seconds } = formatTime(music.currentTime);
      progressLine.style.width = progressWidth +  'px';
      audioDot.style.left = progressWidth - 3 + 'px';
      currentTimeWrapper.textContent = `${numbers(minutes)}:${numbers(seconds)}`;
    };

    const numbers = number => {
      return parseInt(number / 10) + "" + number % 10;
    }

    const { minutes, seconds }= formatTime(duration);
    document.querySelector('.audio-duration').textContent = 
    `${numbers(minutes)}:${numbers(seconds)}`;

    const setTime = event => {
      let { clientX } = event;
      const pos = timeLine.getBoundingClientRect().left;
      
      clientX -= pos;
      progressLine.style.width = clientX + 'px';
      const time = duration / (timeLineWidth / progressLine.offsetWidth) 

      music.currentTime = time;
    };

    buttonPlay.addEventListener('click',  playStart);

    music.addEventListener('timeupdate', timeUpdate);
    
    audioDot.addEventListener('mousedown', () => {
      window.addEventListener('mousemove', setTime);
    });

    window.addEventListener('mouseup', () => {
      window.removeEventListener('mousemove', setTime);
    });

    music.addEventListener('ended', () => {
      playStart();
      currentTimeWrapper.textContent = '00:00'
      progressLine.style.width = 0;
      audioDot.style.left = 0 + 'px';
    });
  }

});