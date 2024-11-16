let circularProgress = document.querySelector(".circular-progress"),
    progressValue = document.querySelector(".progress-value");

let progressStartValue = 0,
    progressEndValue = 90,
    speed = 100;

let progress = setInterval(() => {
    progressStartValue++;

    progressValue.textContent = `${progressStartValue}%`
    circularProgress.style.background = `conic-gradient(rgb(17, 32, 146)  ${progressStartValue * 3.6}deg, #f5f4fc 0deg)`

    if (progressStartValue == progressEndValue) {
        clearInterval(progress);
    }
}, speed);
