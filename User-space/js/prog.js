

let circularProgress = document.querySelector(".circular-progress11"),
  progressValue = document.querySelector(".progress-value11");


let progressStartValue = 0,
  progressEndValue = parseInt(document.querySelector(".progress-value11").textContent),
  speed = 100;
if (progressEndValue != 0) {

  let progress = setInterval(() => {
    progressStartValue++;

    progressValue.textContent = `${progressStartValue}%`
    circularProgress.style.background = `conic-gradient(#112092 ${progressStartValue * 3.6}deg, #ededed 0deg)`

    if (progressStartValue == progressEndValue) {
      clearInterval(progress);
    }
  }, speed);

}
