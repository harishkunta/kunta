const configValues = window.drupalSettings.config,
    annual_oop_repair_factor_low = configValues.annual_oop_repair_factor_low ? configValues.annual_oop_repair_factor_low : 53,
    annual_oop_repair_factor_high = configValues.annual_oop_repair_factor_high ? configValues.annual_oop_repair_factor_high : 148,
    annual_oop_repair_factor_average = configValues.annual_oop_repair_factor_average ? configValues.annual_oop_repair_factor_average : 100,
    reprocessing_range_low = configValues.reprocessing_range_low ? configValues.reprocessing_range_low : 50.14,
    reprocessing_range_high = configValues.reprocessing_range_high ? configValues.reprocessing_range_high : 152.66,
    reprocessing_range_average = configValues.reprocessing_range_average ? configValues.reprocessing_range_average : 101.43,
    cross_contamination_factor_a = configValues.cross_contamination_factor_a ? configValues.cross_contamination_factor_a : 0.034,
    cross_contamination_factor_b = configValues.cross_contamination_factor_b ? configValues.cross_contamination_factor_b : 0.2125,
    cost_per_infection = configValues.cost_per_infection ? configValues.cost_per_infection : 28383;

//to calculate maintenance cost
function calculateMaintenanceCost() {
    var $totalprocedures = $('#edit-total-annual-bronchoscopy-procedures').val();
    var $repairstatus = $('#edit-annual-out-of-pocket-repair-cost').val();
    var $repaircost = $repairstatus < 50 ? annual_oop_repair_factor_low : ($repairstatus > 50 ? annual_oop_repair_factor_high : annual_oop_repair_factor_average);
    $('.currentAnnualOopRepairAllFactor_slider').find('span').text(`$${Intl.NumberFormat().format($totalprocedures * $repaircost)}`);
}
//to calculate reprocessing cost
function calculateReprocessingCost() {
    var $processingValue = $('#edit-reprocessing-costs-method').val();
    var $processingCost = $processingValue < 50 ? reprocessing_range_low : ($processingValue > 50 ? reprocessing_range_high : reprocessing_range_average);
    $('.reprocessingCalcMethod_slider').find('span').text(`$${Intl.NumberFormat().format($processingCost)}`);
}
//to calculate cross contamination infection cost
function calculateCrossContaminationInfectionCost() {
    var $totalProcedures = $('#edit-total-annual-bronchoscopy-procedures').val(),
        $totalCost = Math.fround(($totalProcedures * cross_contamination_factor_a * cross_contamination_factor_b).toFixed(2)),
        $annualTreatmentCost = Math.floor(($totalCost * cost_per_infection) + 0.5);
    $('#estimatedNumberOfInfections_statistics').find('figure').text(Intl.NumberFormat().format($totalCost));
    $('#estimatedAnnualTreatmentCost_statistics').find('figure').text(`$${Intl.NumberFormat().format($annualTreatmentCost)}`);
}


function validateInput(id, type) {
    let errorId = $("#" + id).closest(".question").find(".error").attr("id");
    let errorCheck = false;
    if (type === "textFieldInput") {
        if (!$("#" + id).val()) {
            // $("#" + errorId).html("Please enter the name of your facility.")
            $("#" + errorId).css("display", "block");
            errorCheck = true;
        } else {
            $("#" + errorId).css("display", "none");
        }
    } else if (type === "numberFieldInput") {
        if ($("#" + id).attr("max") && ($("#" + id).val() > Number($("#" + id).attr("max")))) {
            $("#" + errorId).html("The max value is " + $("#" + id).attr("max") + ".");
            !$("#" + errorId).hasClass("active") ? $("#" + errorId).addClass("active") : null;
            errorCheck = true;
        } else {
            $("#" + errorId).removeClass("active")
        }
    } else if (type === "sliderFieldInput") {
        if (id == "edit-procedures-count-single-usage" || id == "edit-total-annual-bronchoscopy-procedures") {
            let value1 = Number($("#edit-procedures-count-single-usage").val())
            let value2 = Number($("#edit-total-annual-bronchoscopy-procedures").val())
            let numberOfProcedures_errorId = "numberOfProcedures_slider_1_textfieldError"
            if (value1 > value2) {
                // $("#" + numberOfProcedures_errorId).html("This value must be less than or equal to the total annual bronchoscopy procedures.");
                !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
                errorCheck = true;
            } else {
                $("#" + numberOfProcedures_errorId).removeClass("active");
                $("#" + errorId).removeClass("active");
                calculateMaintenanceCost();
                calculateCrossContaminationInfectionCost();
            }
        } else {
            $("#" + errorId).removeClass("active");
        }
    } else if (type === "slider_numberFieldInput") {
        let sliderId = $("#" + id).closest(".question").find(".slider").attr("id");
        if (id == "numberOfProcedures_slider_1_number" || id == "bronchoscopyProcedures_slider_1_number") {
            let value1 = Number($("#numberOfProcedures_slider_1_number").val())
            let value2 = Number($("#bronchoscopyProcedures_slider_1_number").val())
            let numberOfProcedures_errorId = "numberOfProcedures_slider_1_textfieldError";
            if (value1 > value2 && !(Number($("#" + id).val()) > $("#" + sliderId).attr("max") || Number($("#" + id).val()) < $("#" + sliderId).attr("min"))) {
                $("#" + numberOfProcedures_errorId).html("This value must be less than or equal to the total annual bronchoscopy procedures.");
                !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
                errorCheck = true;
            } else if (value1 <= value2 && (Number($("#" + id).val()) > $("#" + sliderId).attr("max") || Number($("#" + id).val()) < $("#" + sliderId).attr("min"))) {
                $("#" + errorId).html("The value must be between " + $("#" + sliderId).attr("min") + " and " + $("#" + sliderId).attr("max") + ".");
                !$("#" + errorId).hasClass("active") ? $("#" + errorId).addClass("active") : null;
                errorCheck = true;
            } else {
                if (id == "bronchoscopyProcedures_slider_1_number") {
                    if (value1 > value2 && (Number($("#" + id).val()) > $("#" + sliderId).attr("max") || Number($("#" + id).val()) < $("#" + sliderId).attr("min"))) {
                        $("#" + errorId).html("The value must be between " + $("#" + sliderId).attr("min") + " and " + $("#" + sliderId).attr("max") + ".")
                        $("#" + numberOfProcedures_errorId).html("This value must be less than or equal to the total annual bronchoscopy procedures.");
                        !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
                        !$("#" + errorId).hasClass("active") ? $("#" + errorId).addClass("active") : null;
                        errorCheck = true;
                    } else {
                        calculateMaintenanceCost();
                        calculateCrossContaminationInfectionCost();
                        $("#" + errorId).removeClass("active");
                    }
                } else {
                    if (value1 > value2 && (Number($("#" + id).val()) > $("#" + sliderId).attr("max") || Number($("#" + id).val()) < $("#" + sliderId).attr("min"))) {
                        $("#" + errorId).html("The value must be between " + $("#" + sliderId).attr("min") + " and " + $("#" + sliderId).attr("max") + ". " + "This value must be less than or equal to the total annual bronchoscopy procedures.");
                        !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
                        errorCheck = true;
                    } else {
                        $("#" + numberOfProcedures_errorId).removeClass("active");
                    }
                }
            }
        } else {
            if (Number($("#" + id).val()) > $("#" + sliderId).attr("max") || Number($("#" + id).val()) < $("#" + sliderId).attr("min")) {
                $("#" + errorId).html("The value must be between " + $("#" + sliderId).attr("min") + " and " + $("#" + sliderId).attr("max") + ".")
                $("#" + errorId).addClass("active");
                errorCheck = true;
            } else {
                $("#" + errorId).removeClass("active");
            }
        }
    }
    let checkOverallErrors = false;
    $(".error").each(function () {
        if (($(this).css('display') == 'block') || ($(".error.active").length > 0)) {
            checkOverallErrors = true;
        }
    })
    let button = $("#edit-submit");
    if (checkOverallErrors == true) {
        button.prop('disabled', true);
        button.addClass("disabled");
        !$("#disableSubmitText").length ? $("<span class='disableSubmitText' id='disableSubmitText'>Fix form errors in <em>red</em> to calculate.</span>").insertAfter("#edit-submit") : null;
        $("#disableSubmitText").length ? $("#disableSubmitText").css("display", "inline") : null;
    } else {
        button.prop('disabled', false);
        button.removeClass("disabled");
        $("#disableSubmitText").length ? $("#disableSubmitText").css("display", "none") : null;
    }
    return errorCheck;
}


// Custom methods
//(type is expected to be only slider, number or tooltip)
// function: makes number fields and slider fields responsive to one another in each question element and shows tooltip when clicked on icon.

function triggerAction(id, type) {
    if (type == "slider") {
        let numInput = $("#" + id).closest(".question").find("input[type=number]");
        if (numInput.length) {
            numInput.val($("#" + id).val())
            numInput.attr("value", numInput.val())
            $("#" + id).closest(".question").find("input[type=number]") ? $("#" + id).closest(".question").find("input[type=number]").val($("#" + id).val()) : null;
        }
    } else if (type == "number") {
        let rangeInput = $("#" + id).closest(".question").find("input[type=range]");
        rangeInput.val($("#" + id).val())
        rangeInput.attr("value", rangeInput.val())
    } else {
        let toggleTip = $("#" + id).closest(".question").find(".tooktipTextBoxWrapper").attr("id");
        document.getElementById(toggleTip).classList.toggle("active");
    }
}

// This method is created to submit the BFlex form.

// Final Trigger for the module's js code execution.
(function ($, Drupal) {


    //Behavior definition for tooltip.
    Drupal.behaviors.tooltip = {
        attach: function (context, settings) {
            $(".tooltip-icon", context).each(function () {
                $(this).on('click', function () {
                    triggerAction($(this).attr("id"), "tooltip")
                });
            });
        }
    };

    // Behavior Definition for Slider.
    Drupal.behaviors.slider = {
        attach: function (context, settings) {
            $(".slider", context).each(function () {
                $(this).on('change', function () {
                    let sliderId = $(this).attr("id");
                    triggerAction(sliderId, "slider");
                    validateInput(sliderId, "sliderFieldInput");
                    $("#" + sliderId).attr("value", $("#" + sliderId).val());
                    if (sliderId == "edit-procedures-count-single-usage" || sliderId == "edit-annual-out-of-pocket-repair-cost") {
                        calculateMaintenanceCost();
                    } else if (sliderId == "edit-reprocessing-costs-method") {
                        calculateReprocessingCost();
                    }
                });
            });
        }
    };

    // Behavior defination of Number calculations.
    Drupal.behaviors.number = {
        attach: function (context, settings) {
            $(".number", context).each(function () {
                $(this).on('change', function () {
                    let numberId = $(this).attr("id")
                    triggerAction(numberId, "number")
                    validateInput(numberId, "slider_numberFieldInput")
                    $("#" + numberId).attr("value", $("#" + numberId).val())
                    if (numberId == "bronchoscopyProcedures_slider_1_number") {
                        calculateMaintenanceCost();
                        calculateCrossContaminationInfectionCost();
                    }
                });
            });
        }
    }

    // Behavior definition for Textfield & Number box.
    Drupal.behaviors.input = {
        attach: function (context, settings) {
            $(".form-text", context).each(function () {
                $(this).on('focusout', function () {
                    let textFieldId = $(this).attr("id")
                    validateInput(textFieldId, "textFieldInput");
                    $("#" + textFieldId).attr("value", $("#" + textFieldId).val());
                });
            });

            $(".form-number", context).each(function () {
                $(this).on('change', function () {
                    let numberId = $(this).attr("id")
                    validateInput(numberId, "numberFieldInput")
                    $("#" + numberId).attr("value", $("#" + numberId).val());
                });
            });
        }
    };

    calculateMaintenanceCost();
    calculateReprocessingCost();
    calculateCrossContaminationInfectionCost();

})(jQuery, Drupal);