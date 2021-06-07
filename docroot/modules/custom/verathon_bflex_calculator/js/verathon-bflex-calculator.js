// Custom methods
function getIdFromClass(classId, pushString) {
  let splitId = classId.split("_")
  splitId.pop()
  splitId.push(pushString)
  let finalId = splitId.join("_")
  return finalId
}

function validateInput(id) {
  let splitid = id.split("_")
  let questionType = splitid[0] + "_" + splitid[1];
  let key = splitid[2];
  let currentValues = bflexCalculator.steps[key].right[questionType];
  let sliderId = getIdFromClass(id, "slider")
  let errorId = getIdFromClass(id, "textfieldError");
  let errorCheck = false;

  if (splitid[3] == "textField") {
    if (!$("#" + id).val()) {
      $("#" + errorId).css("display", "block");
      errorCheck = true;
    }
    else {
      $("#" + errorId).css("display", "none");
    }
  }

  else if (splitid[3] == "numberfield") {
    if ($("#" + id).val() > bflexCalculator.steps[key].right[questionType].max) {
      document.querySelector("#" + questionType + "_" + key + "_textfieldError").innerHTML = "The max value is " + bflexCalculator.steps[key].right[questionType].max + "."
      !$("#" + getIdFromClass(id, "textfieldError")).hasClass("active") ? $("#" + getIdFromClass(id, "textfieldError")).addClass("active") : null;
      errorCheck = true;
    }
    else {
      $("#" + getIdFromClass(id, "textfieldError")).removeClass("active")
    }
  }

  else if (splitid[3] == "slider") {
    if (id == "numberOfProcedures_slider_1_slider" || id == "bronchoscopyProcedures_slider_1_slider") {
      let splitid = "numberOfProcedures_slider_1_slider".split("_")
      let questionType = splitid[0] + "_" + splitid[1];
      let key = splitid[2];
      let currentValues = bflexCalculator.steps[key].right[questionType];
      let value1 = Number($("#numberOfProcedures_slider_1_slider").val())
      let value2 = Number($("#bronchoscopyProcedures_slider_1_slider").val())
      let numberOfProcedures_errorId = "numberOfProcedures_slider_1_textfieldError"
      if (value1 > value2) {
        $("#" + numberOfProcedures_errorId).html(currentValues.error)
        !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
        errorCheck = true;
      } else if (value1 < value2) {
        $("#" + numberOfProcedures_errorId).removeClass("active");
        $("#" + errorId).removeClass("active");
        calculateMaintenanceCost();
        calculateCrossContaminationInfectionCost();
      }
    }
    else {
      $("#" + errorId).removeClass("active");
    }
  }


  else if (splitid[3] == "number") {
    if (id == "numberOfProcedures_slider_1_number" || id == "bronchoscopyProcedures_slider_1_number") {
      let value1 = Number($("#numberOfProcedures_slider_1_number").val())
      let value2 = Number($("#bronchoscopyProcedures_slider_1_number").val())
      let numberOfProcedures_errorId = "numberOfProcedures_slider_1_textfieldError"
      if (value1 > value2 && !(Number($("#" + questionType + "_" + key + "_number").val()) > currentValues.max || Number($("#" + questionType + "_" + key + "_number").val()) < currentValues.min)) {
        $("#" + numberOfProcedures_errorId).html(bflexCalculator.steps[1].right['numberOfProcedures_slider'].error)
        !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
        errorCheck = true;
      }
      else if (value1 <= value2 && (Number($("#" + questionType + "_" + key + "_number").val()) > currentValues.max || Number($("#" + questionType + "_" + key + "_number").val()) < currentValues.min)) {
        $("#" + errorId).html("The value must be between " + currentValues.min + " and " + currentValues.max + ".")
        !$("#" + errorId).hasClass("active") ? $("#" + errorId).addClass("active") : null;
        errorCheck = true;
      }
      else {
        if (id == "bronchoscopyProcedures_slider_1_number") {
          if (value1 > value2 && (Number($("#" + questionType + "_" + key + "_number").val()) > currentValues.max || Number($("#" + questionType + "_" + key + "_number").val()) < currentValues.min)) {
            $("#" + questionType + "_" + key + "_textfieldError").html("The value must be between " + currentValues.min + " and " + currentValues.max + ".")
            $("#" + numberOfProcedures_errorId).html(bflexCalculator.steps[1].right['numberOfProcedures_slider'].error)
            !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
            !$("#" + errorId).hasClass("active") ? $("#" + errorId).addClass("active") : null;
            errorCheck = true;
          }
          else {
            calculateMaintenanceCost();
            calculateCrossContaminationInfectionCost();
            $("#" + errorId).removeClass("active");
          }
        }
        else {
          if (value1 > value2 && (Number($("#" + questionType + "_" + key + "_number").val()) > currentValues.max || Number($("#" + questionType + "_" + key + "_number").val()) < currentValues.min)) {
            $("#" + questionType + "_" + key + "_textfieldError").html("The value must be between " + currentValues.min + " and " + currentValues.max + ". " + currentValues.error)
            !$("#" + numberOfProcedures_errorId).hasClass("active") ? $("#" + numberOfProcedures_errorId).addClass("active") : null;
            errorCheck = true;
          }
          else {
            $("#" + numberOfProcedures_errorId).removeClass("active");
          }
        }
      }
    }
    else if (id != ("numberOfProcedures_slider_1_number" || "bronchoscopyProcedures_slider_1_number")) {
      if (Number($("#" + questionType + "_" + key + "_number").val()) > currentValues.max || Number($("#" + questionType + "_" + key + "_number").val()) < currentValues.min) {
        $("#" + questionType + "_" + key + "_textfieldError").html("The value must be between " + currentValues.min + " and " + currentValues.max + ".")
        $("#" + errorId).addClass("active");
        errorCheck = true;
      }
      else {
        $("#" + errorId).removeClass("active");
      }
    }
  }
  return errorCheck;
}

(function ($, Drupal) {
  // Behavior definition for tooltip.
  Drupal.behaviors.tooltip = {
    attach: function (context, settings) {
      $(".tooltip-icon", context).each(function () {
        $(this).on('click', function () {
          let iconId = $(this).attr("id")
          let toggleTipId = getIdFromClass(iconId, "toggleTip")
          document.getElementById(toggleTipId).classList.toggle("active");
        });
      });
    }
  };

  // Behavior Definition for Slider.
  Drupal.behaviors.slider = {
    attach: function (context, settings) {
      $(".slider").each(function () {
        $(this).on('change', function () {
          let sliderId = $(this).attr("id")
          let numberId = getIdFromClass(sliderId, "number");
          validateInput(sliderId)
          $("#" + sliderId).attr("value", $("#" + sliderId).val())
          $("#" + numberId).attr("value", $("#" + sliderId).val())
          if (sliderId == "currentAnnualOopRepairAllFactor_slider_2_slider") {
            calculateMaintenanceCost();
          } else if (sliderId == "reprocessingCalcMethod_slider_3_slider") {
            calculateReprocessingCost();
          }
          document.getElementById(numberId) ? document.getElementById(numberId).value = document.getElementById(sliderId).value : null;
        });
      });
    }
  };

  // Behavior definition for Textfield & Number box.
  Drupal.behaviors.input = {
    attach: function (context, settings) {

      $(".textField", context).each(function () {
        $(this).on('focusOut', function () {
          let textFieldId = $(this).attr("id")
          validateInput(textFieldId)
          $("#" + textFieldId).attr("value", $("#" + textFieldId).val());
        });
      });

      $(".numberfield", context).each(function () {
        $(this).on('change', function () {
          let numberId = $(this).attr("id")
          validateInput(numberId)
          $("#" + numberId).attr("value", $("#" + numberId).val());
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
          let sliderId = getIdFromClass(numberId, "slider")
          validateInput(numberId)
          $("#" + numberId).attr("value", $("#" + numberId).val())
          $("#" + sliderId).attr("value", $("#" + numberId).val())
          document.getElementById(sliderId).value = document.getElementById(numberId).value;
          if (numberId == "bronchoscopyProcedures_slider_1_number") {
            calculateMaintenanceCost();
            calculateCrossContaminationInfectionCost();
          }
        });
      });
    }
  }


})(jQuery, Drupal);






