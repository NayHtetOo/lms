// let examDuration = @json($this->exams->duration);
//     let userId = @json($user_id);
//     let examId = @json($id);
//     const csrfToken = document.getElementById("csrfToken").getAttribute("content");
//     let startDate = new Date(@json($startDate));
//     let endDate = new Date(@json($endDate));
//     let currentDate = new Date(@json($currentDate))
    let examMinutes = document.getElementById("examMinutes");
    let examViewContainer = document.getElementById("examViewContainer");
    let examDescription = document.getElementById("examDescription");

    let postData = {
        'user_id': userId,
        'exam_id': examId,
        'status': 1,
    }
    let options = {
        method: 'POST',
        headers: {
            'Content-Type': "application/json",
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(postData)
    }
    let getLocalStorage = JSON.parse(localStorage.getItem('storeDuration'));
    let getFormStatus = JSON.parse(localStorage.getItem('formStatus'));

    if (!getFormStatus) {
        let storeFormStatus = localStorage.setItem('formStatus', JSON.stringify({
            status: false,
        }));
    }

    if (!getLocalStorage) {
        localStorage.setItem('storeDuration', JSON.stringify({
            storeMinutes: examDuration,
            storeSeconds: 60,
        }));
    }

    getLocalStorage = JSON.parse(localStorage.getItem('storeDuration'));
    getFormStatus = JSON.parse(localStorage.getItem('formStatus'));
    console.log(getFormStatus);


    document.getElementById("answer").addEventListener("click", function() {
        localStorage.setItem('formStatus', JSON.stringify({
            status: true,
        }));
        console.log(getFormStatus);
        FormLoad();
    });

    window.addEventListener("load", function() {
        console.log("load");
        FormLoad();
    });

    function FormLoad() {
        getFormStatus = JSON.parse(localStorage.getItem('formStatus'));
        if (getFormStatus.status == true && getFormStatus) {
            document.getElementById("form").classList.remove("hidden");
            examViewContainer.classList.add('flex');
            examDescription.classList.remove('w-full');
            examDescription.classList.remove('mx-auto');
            examDescription.classList.add('w-1/4');
            examDurationCount();
        } else {
            document.getElementById("form").classList.add("hidden");
            examViewContainer.classList.remove('flex');
            examDescription.classList.add('w-full');
            examDescription.classList.add('mx-auto');
            examDescription.classList.remove('w-1/4');
        }
    }

    function examDurationCount() {
        if (currentDate > startDate && currentDate < endDate) {
            console.log('date between')
            const intervalExam = setInterval(() => {

                if (getLocalStorage.storeMinutes != null || getLocalStorage.storeSeconds != null) {
                    getLocalStorage.storeSeconds--;
                } else {
                    examMinutes.style.display = "none";
                }

                localStorage.setItem('storeDuration', JSON.stringify(getLocalStorage));

                if (getLocalStorage.storeSeconds == 0) {
                    if (getLocalStorage.storeMinutes >= 0) {
                        getLocalStorage.storeMinutes--;
                        getLocalStorage.storeSeconds = 59;
                    }

                    console.log(getLocalStorage.storeMinutes);

                    if (getLocalStorage.storeMinutes == 0) {
                        console.log(getFormStatus.status);
                        const apiUrl = "/submit";
                        fetch(apiUrl, options)
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error(`Error status ${response.status}`);
                                }
                                return response.json();
                            })
                            .then((data) => {
                                clearInterval(intervalExam);
                                localStorage.setItem('storeDuration', JSON.stringify({
                                    storeMinutes: null,
                                    storeSeconds: null,
                                }));
                                examMinutes.textContent = "";
                                localStorage.removeItem('formStatus');
                                document.getElementById("form").classList.add("hidden");
                                examViewContainer.classList.remove('flex');
                                examDescription.classList.add('w-full');
                                examDescription.classList.add('mx-auto');
                                examDescription.classList.remove('w-1/4');
                            })
                            .catch(error => {
                                console.error(`Error ${error}`);
                            });
                    }
                }
                examMinutes.textContent = `${getLocalStorage.storeMinutes} : ${getLocalStorage.storeSeconds}`;
            }, 1000);
        } else {
            console.log("exam is not started");
        }
    }
