$(document).ready(function() {
    $("#addStep").click(function() {
        let stepCount = $(".stepGroup").length;
        let newStepGroup = $(".stepGroup").first().clone();
        let newStepNumber = stepCount + 1;

        newStepGroup.find("label").attr("for", "step-" + newStepNumber).text(newStepNumber);
        newStepGroup.find("input").attr("id", "stepnumber-" + newStepNumber).val(newStepNumber);
        newStepGroup.find("input").attr('value' , newStepNumber);
        newStepGroup.find("textarea").attr("id", "step-" + newStepNumber).val("");

        $("#stepContainer").append(newStepGroup);
    });

    $(document).on('click', '.remove', function() {
        if ($('.stepGroup').length > 1) {
            $(this).closest('.stepGroup').remove();

            $(".stepGroup").each(function(index) {
                let newStepNumber = index + 1;
                $(this).find("label").attr("for", "step-" + newStepNumber).text(newStepNumber);
                $(this).find("input").attr("id", "stepnumber-" + newStepNumber).val(newStepNumber);
                $(this).find("input").attr('value' , newStepNumber);
                $(this).find("textarea").attr("id", "step-" + newStepNumber);
            });
        }
    });
});


