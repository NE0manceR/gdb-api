$.ajax({
  url: window.location.origin + "/views/brand",
  method: "POST",
  data: {},
  dataType: "json",

  success: function (response) {
    response.brands.forEach((element) => {
      let newOption = $("<option>")
        .val(element.brandName)
        .text(element.brandName);
      $("#brandName").append(newOption);
    });

    response.skills.forEach((element) => {
      let newOption = $("<option>").val(element.id).text(element.brandName);
      $("#brandOneItem, #brandTwoItem, #brandThreeItem").append(newOption);
    });
  },

  error: function (err) {
    console.log("Помилка запиту:", err);
    console.log("Текст помилки: ");
  },
});

function update_brand() {
  const formData = new FormData(document.getElementById("update_brand"));

  $.ajax({
    url: window.location.origin + "/views/brand/add",
    type: "POST",
    data: formData,
    processData: false,
    contentType: false,
    enctype: "multipart/form-data",
    success: function (response) {
      console.log("Success:", JSON.parse(response));
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });
}

$("form .add-cat-btn").on("click", function () {
  update_brand();
});
