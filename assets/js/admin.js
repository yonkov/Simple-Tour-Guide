(function () {

    let counter = +scriptParams.counter;
    const isShowWpEditor = scriptParams.show_wp_editor;
    const table = document.getElementsByTagName('table')[0];
    const strings = scriptParams.strings;
    const addStepButton = document.getElementById('stg_steps') || '';
    const removeStepButton = document.getElementById('stg_remove_steps') || '';

    function addNewStep() {
        const steps = document.getElementsByClassName('step');
        const lastStep = steps[steps.length - 1];

        // get last step input fields
        const lastStepFields = lastStep.getElementsByClassName('form-field');
        const lastTextArea = lastStepFields[1];

        // remove wp editor from last step description field to be able to copy it
        if (typeof wp.editor != "undefined" && isShowWpEditor) {
            wp.editor.remove(lastTextArea.id);
        }

        //new table body wrapper
        const tbody_element = document.createElement('tbody');
        tbody_element.className = 'step';

        //create the new step
        let newStep = lastStep.cloneNode(true);
        table.appendChild(newStep);

        table.insertBefore(newStep, lastStep)

        // loop through last step fields to increment ids
        for (let i = 0, n = lastStepFields.length; i < n; i++) {
            const field = lastStepFields[i];
            // set the id and name attribute
            if (i == 0) {
                field.name = "stg_tour[title_" + counter + ']';
                field.value = '';
            }
            else if (i == 1) {
                field.name = "stg_tour[description_" + counter + ']';
                field.value = '';

                //generate the wp editor
                if (typeof wp.editor != "undefined" && isShowWpEditor) {

                    generateWpEditor(field.id);

                    // increment textarea id
                    field.id = 'id_' + counter;

                    generateWpEditor(field.id);
                }

            }
            else if (i == 2) {
                field.name = "stg_tour[location_" + counter + ']';
                field.value = '';
            }
            else if (i == 3) {
                field.name = "stg_tour[classname_" + counter + ']';
                field.value = '';
            }
        }
    }

    function removeStep() {
        const steps = document.getElementsByClassName('step');
        if (steps.length > 1) {
            const result = confirm(strings.removeMessage);
            if (result) {
                const lastStep = steps[steps.length - 1];
                const lastTextArea = lastStep.getElementsByClassName('form-field')[1];
                lastStep.remove();
                if (typeof wp.editor != "undefined" && isShowWpEditor) {
                    wp.editor.remove(lastTextArea.id);
                }
                counter--;
            }
        }
    }

    // helper to initialize wp editor dynamically
    function generateWpEditor(id) {
        wp.editor.initialize(id, {
            tinymce: {
                plugins: 'paste,lists,link,media,wordpress,wpeditimage,wpgallery,wpdialogs,wplink,textcolor,colorpicker',
                toolbar1: 'bold italic underline strikethrough | blockquote bullist numlist | alignleft aligncenter alignright alignjustify',
                toolbar2: 'formatselect removeformat forecolor link unlink',
                textarea_rows: 5
            },
            quicktags: true,
            mediaButtons: true,
        });
    }

    //clean up storage on all forms for a smoother user experience
    if (document.getElementsByClassName('stg-form').length > 0) {
        document.getElementsByClassName('stg-form')[0].onsubmit = function onSubmit() {
            localStorage.removeItem('tour-guide');
        };
    }
    if(addStepButton){
        addStepButton.addEventListener('click', function (e) {
            e.preventDefault();
            counter++;
            addNewStep();
            localStorage.removeItem('tour-guide');
        });
    }
    if(removeStepButton){
        removeStepButton.addEventListener('click', function (e) {
            e.preventDefault();
            removeStep();
            localStorage.removeItem('tour-guide');
        });
    }

    // store counter in db before submitting the form
    jQuery('form[name="stgFormOne"]').submit(function (e) {
        localStorage.removeItem('tour-guide');
        nonce = jQuery(this).attr("data-nonce");
        jQuery.ajax({
            url: ajaxurl,
            dataType: "json",
            data: {
                action: 'save_counter',
                'counter': counter,
                nonce: nonce
            },
            type: 'post',
            async: false
        })
    });

})();