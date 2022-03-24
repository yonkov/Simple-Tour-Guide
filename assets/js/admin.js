(function () {

    let counter = +scriptParams.counter;
    const isShowWpEditor = scriptParams.show_wp_editor;
    const table = document.getElementsByTagName('table')[0];
    const steps = document.getElementsByClassName('step');

    function addNewStep() {
        const lastStep = steps[steps.length - 1];

        // get last step input fields
        const lastStepFields = lastStep.getElementsByClassName('form-field');
        const lastTextArea = lastStepFields[1];
        
        // remove wp editor from last step description field to be able to copy it
        if (typeof wp.editor != "undefined" && isShowWpEditor){
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
                if (typeof wp.editor != "undefined" && isShowWpEditor){

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
        if(steps.length>1){
            const lastStep = steps[steps.length - 1];
            lastStep.remove();
        }
    }

    // initializes wp editor dynamically
    function generateWpEditor(id){
        wp.editor.initialize(id, {
            tinymce: {
                plugins: 'paste,lists,link,media,wordpress,wpeditimage,wpgallery,wpdialogs,wplink,textcolor,colorpicker',
                toolbar1: 'bold italic underline strikethrough | blockquote bullist numlist | alignleft aligncenter alignright alignjustify',
                toolbar2: 'formatselect removeformat forecolor link unlink',
                textarea_rows : 5
            },
            quicktags: true,
            mediaButtons: true,
        });
    }

    //clean up storage on form submit for a smoother user experience
    if (document.getElementsByClassName('stg-form').length > 0) {
        document.getElementsByClassName('stg-form')[0].onsubmit = function onSubmit() {
            localStorage.removeItem('tour-guide');
        };
    }

    //increment counter
    document.getElementById('stg_steps').addEventListener('click',function (e) {
        e.preventDefault();
        counter++;
        addNewStep();
        localStorage.removeItem('tour-guide');
    });

    //decrement counter
    document.getElementById('stg_remove_steps').addEventListener('click',function (e) {
        e.preventDefault();
        removeStep();
        if(counter>1){
            counter--;
        }
    });

    jQuery('.stg-form').submit(function (e) {
        nonce = jQuery(this).attr("data-nonce");
        jQuery.ajax({
            url: ajaxurl,
            dataType: "json",
            data: {
                action: 'save_counter',
                'counter' : counter,
                 nonce: nonce
            },
            type: 'post',
            async: false
        })
    });

})();