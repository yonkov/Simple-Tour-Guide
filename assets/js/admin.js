(function () {

    let counter = +scriptParams.counter;
    const isShowWpEditor = scriptParams.show_wp_editor;
    console.log(isShowWpEditor);
    const table = document.getElementsByTagName('table')[0];

    let newId ='';

    function addNewStep() {
        //get all steps
        const steps = document.getElementsByClassName('step');
        const lastStep = steps[steps.length - 1];

        // get last step input fields
        const lastStepFields = lastStep.getElementsByClassName('form-field');
        
        // remove wp editor from last step to be able to copy it
        if (typeof wp.editor != "undefined" && isShowWpEditor){
            wp.editor.remove(lastStepFields[1].id);
        }

        //new table body wrapper
        const tbody_element = document.createElement('tbody');
        tbody_element.className = 'step';

        //create the new step
        let newStep = lastStep.cloneNode(true);
        table.appendChild(newStep);

        table.insertBefore(newStep, lastStep)

        // loop through last step fields and provide unique ids
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
                // increment textarea id to match it with the wp editor screen
                newId = +(field.id.replace('id','')) + 1;

                //reapply the wp editor
                if (typeof wp.editor != "undefined" && isShowWpEditor){
                    wp.editor.initialize(field.id, {
                        tinymce: {
                            plugins: 'paste,lists,link,media,wordpress,wpeditimage,wpgallery,wpdialogs,wplink,textcolor,colorpicker',
                            toolbar1: 'bold italic underline strikethrough | blockquote bullist numlist | alignleft aligncenter alignright alignjustify',
                            toolbar2: 'formatselect forecolor link unlink',
                            textarea_rows : 5
                        },
                        quicktags: true,
                        mediaButtons: true,
    
                    });

                    field.id = 'id' + newId;
                    wp.editor.initialize(field.id, {
                        tinymce: {
                            plugins: 'paste,lists,link,media,wordpress,wpeditimage,wpgallery,wpdialogs,wplink,textcolor,colorpicker',
                            toolbar1: 'bold italic underline strikethrough | blockquote bullist numlist | alignleft aligncenter alignright alignjustify',
                            toolbar2: 'formatselect forecolor link unlink',
                            textarea_rows : 5
                        },
                        quicktags: true,
                        mediaButtons: true,
                    });
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
        const lastStep = steps[steps.length - 1];
        lastStep.remove();
    }

    //clean up storage on form submit for a smoother user experience
    if (document.getElementsByClassName('stg-form').length > 0) {
        document.getElementsByClassName('stg-form')[0].onsubmit = function onSubmit() {
            localStorage.removeItem('tour-guide');
        };
    }

    //increment counter
    jQuery('#stg_steps').click(function (e) {
        e.preventDefault();
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'increment_counter',
            },
            type: 'POST',
        })
            .done(addNewStep)
            .fail(function (xhr) {
                console.log(xhr);
            })
        counter++;
        localStorage.removeItem('tour-guide');
    });

    //decrement counter
    jQuery('#stg_remove_steps').click(function (e) {
        e.preventDefault();
        jQuery.ajax({
            url: ajaxurl,
            data: {
                action: 'decrement_counter',
            },
            type: 'POST',
        })
            .done(removeStep)
            .fail(function (xhr) {
                console.log(xhr);
            })
        counter--;
    });

})();