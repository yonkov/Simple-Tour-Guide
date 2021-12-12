(function () {
    const tourObj = scriptParams.tour_object;
    if (!tourObj) {
        localStorage.removeItem('tour-guide');
        return;
    }
    const strings = scriptParams.strings;
    const counter = scriptParams.counter;
    const isDisplayOnce = scriptParams.tour_settings.show_intro;
    const isDisplayShortCode = scriptParams.has_tour;
    const isDisplayAllPages = scriptParams.tour_settings.show_on_all_pages;
    const isConfirmCancel = scriptParams.tour_settings.show_confirmation ? true : false;
    const isDisplayLoggedIn = scriptParams.tour_settings.show_user_logged_in ? true : false;
    const isModalOverlay = scriptParams.tour_settings.show_modal ? true : false;
    const isSkipStep = scriptParams.tour_settings.skip_step ? true : false;
    const isDisplayProgress = scriptParams.tour_settings.show_progress;
    const isAdmin = scriptParams.tour_settings.is_admin;
    const isloggedIn = scriptParams.is_logged_in;

    const stgStepTitles = [];
    const stgStepDescriptions = [];
    const stgStepLocations = [];
    const stgStepClassnames = [];

    const steps = [];  //Construct the steps

    let isBack =false; //flag if back button is pressed

    // get the data and organize it into arrays
    for (i = 0; i < counter; i++) {
        const stgStepTitle = tourObj[`title_${i + 1}`];
        stgStepTitles[i] = stgStepTitle;

        const stgStepDescription = tourObj[`description_${i + 1}`];
        stgStepDescriptions[i] = stgStepDescription;

        const stgStepLocation = tourObj[`location_${i + 1}`];
        stgStepLocations[i] = stgStepLocation;

        const stgStepClassname = tourObj[`classname_${i + 1}`];
        stgStepClassnames[i] = stgStepClassname.startsWith('.') ? stgStepClassname.substring(1) : stgStepClassname;
    }

    const tour = new Shepherd.Tour({
        useModalOverlay: isModalOverlay,
        defaultStepOptions: {
            classes: 'stg',
            scrollTo: true,
            cancelIcon: {
                enabled: true,
                label: strings.close
            },
            when: {
                show: function () {
                    if (!isDisplayProgress) return;
                    const currentStepElement = tour.currentStep.el;
                    const header = currentStepElement.querySelector('.shepherd-footer');
                    const progress = document.createElement('div');
                    const innerBar = document.createElement('span');
                    const progressPercentage = ((tour.steps.indexOf(tour.currentStep) + 1) / tour.steps.length) * 100 + '%';
                    progress.className = 'shepherd-progress-bar';
                    innerBar.style.width = progressPercentage;
                    // if only one button
                    if (document.getElementsByClassName('shepherd-button').length == 1) {
                        progress.style.minWidth = '260px';
                    }
                    progress.appendChild(innerBar);
                    header.insertBefore(progress, currentStepElement.querySelector('.shepherd-button'));
                }
            }
        },
        confirmCancel: isConfirmCancel,
    });

    // collect step data dynamically in a step object and append the step object to the tour array
    for (i = 0; i < counter; i++) {
        const step = {
            title: '',
            text: '',
            attachTo: {
                element: '',
                on: 'bottom'
            },
            classes: '',
            buttons: [
                {
                    text: strings.back,
                    action() {
                        isBack=true;
                        return this.back();
                    }
                },
                {
                    text: strings.next,
                    action() {
                        isBack=false;
                        return this.next();
                    }
                },
                {
                    text: strings.finish,
                    action() {
                        // Dismiss the tour when the finish button is clicked and the option is set via the plugin settings page
                        dismissTour();
                        return this.hide();
                    }

                }
            ],
            beforeShowPromise: () => new Promise((resolve) => {
                if(isSkipStep){
                    const currentIndex = tour.steps.indexOf(tour.getCurrentStep());
                    let currentStep ='';
                    setTimeout(() => {
                        currentStep = tour.steps[currentIndex].el;
                        if (currentStep.hasAttribute('data-popper-reference-hidden')) {
                            if(!isBack){
                                tour.next();
                            }
                            else{
                                tour.back();
                            }
                        }
                    },750);
                    resolve();
                }
                resolve();
            })
        }

        steps[i] = step;
        steps[i].title = stgStepTitles[i];
        steps[i].text = stgStepDescriptions[i];
        steps[i].attachTo.element = stgStepLocations[i];
        steps[i].classes = stgStepClassnames[i];

        //Remove back and finish buttons on first step
        if (i == 0) {
            //remove back button
            steps[i].buttons.splice(0, 1); //array index, number of elements to be removed
            //remove next button when there is only one item
            if (counter == 1) {
                steps[i].buttons.splice(0, 1)
            }
            //remove finish button if there is more than one item
            else if (counter > 1) {
                steps[i].buttons.splice(1, 1)
            }
        }
        //Remove finish button on middle steps
        else if (counter > 1 && i < counter - 1) {
            steps[i].buttons.splice(2, 1)
        }
        //Remove next button on last step
        else if (i == counter - 1) {
            steps[i].buttons.splice(1, 1)
        }
    }

    tour.addSteps(steps);

    // Initiate the tour
    function initiateTour() {
        if (!localStorage.getItem('tour-guide')){
            tour.start();
        } 
    }
    //Trigger the tour
    if(isDisplayLoggedIn){
        if (isloggedIn){
            if (isDisplayAllPages) {
                initiateTour()
            }
            else {
                if (isDisplayShortCode) {
                    initiateTour()
                }
            }
        }
    }
    else {
        if (isDisplayAllPages) {
            initiateTour()
        }
        else {
            if (isDisplayShortCode) {
                initiateTour()
            }
        }
    }

    // Dismiss the tour when the cancel icon is clicked and the option is set via the plugin settings page
    tour.on('cancel', () => {
        dismissTour();
    });

    // Helper to dismiss the tour when the user finishes the tour or dismisses it via the close button
    function dismissTour() {
        if (isDisplayOnce && !isAdmin) {
            if (!localStorage.getItem('tour-guide')) {
                setTimeout(() => {
                    localStorage.setItem('tour-guide', 'yes');
                }, 100);
            }
        }
        else {
            setTimeout(function () {
                localStorage.removeItem('tour-guide');
            }, 100);
        }
    }

})();