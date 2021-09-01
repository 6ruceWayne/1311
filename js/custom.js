$(document).ready(function () {
    /* When page is loaded we make sure there are no addresses already created and written to DB
    If yes - we remove placeholders and write the created addresses sorted by alphabet without reloading the page
    */
    updatePage();

    // When form is submited this function is responsible to send it to the server and ether lets user know something is wrong ether save his new address and update page
    $("form").submit(function (event) {

        var formData = {
            address: $("#address").val(),
            city: $("#city").val(),
            area: $("#area").val(),
            street: $("#street").val(),
            house: $("#house").val(),
            info: $("#add-info").val(),
        };
        $.ajax({
            type: "POST",
            url: "utils/process.php",
            data: formData,
            dataType: "json",
            encode: true,
        }).done(function (data) {
            if (!data.success) {
                showError(data);
            } else {
                clearForm();
                updatePage();
            }
        });

        function showError(data) {
            if (data.errors.address) {
                $("#address").parent().append(
                    '<div class="help-block has-error">' + data.errors.address + "</div>"
                );
            }

            if (data.errors.city) {
                $("#city").parent().append(
                    '<div class="help-block has-error">' + data.errors.city + "</div>"
                );
            }

            if (data.errors.area) {
                $("#area").parent().append(
                    '<div class="help-block has-error">' + data.errors.area + "</div>"
                );
            }
        }

        event.preventDefault();
    });

    // When we send request we should wait to get response so that's why here is used Promise
    function updatePage() {
        getUserData().then(function (data) {
            if (data.length > 0) {
                $(".uo_adr_list").empty();
                buildNewList(data);
            }
        }).catch(function (err) {
            console.log(err);
        })
    }

    function buildNewList(data) {
        data.forEach(function (currentValue) {
            buildNewItem(currentValue);
        });
    }

    function buildNewItem(element) {
        var item = $('<div class="item"></div >');
        item.append('<h3>' + element.address_name + '</h3>');
        var desc = element.city + ', ' + element.area;
        desc = element.street ? desc + ', ' + element.street : desc;
        desc = element.house ? desc + ', ' + element.house : desc;
        desc = element.info ? desc + ', ' + element.info : desc;
        item.append('<p>' + desc + '</p>');
        var actBox = $('<div class="actbox"></div >');
        actBox.append('<a href="#" class="bcross"></a>');
        item.append(actBox);
        $(".uo_adr_list").append(item);
    }

    // When full filled form is saved to the server we clear the form on the page
    function clearForm() {
        $("div").remove(".has-error");
        $("#address").val('');
        $("#city").val('');
        $("#area").val('');
        $("#street").val('');
        $("#house").val('');
        $("#add-info").val('');
    }

    // This is the way to get user data not causing async conflict when script didn't recieve the responce yet but tries to apply it to the page
    function getUserData() {
        return new Promise(function (resolve, reject) {
            $.ajax({
                type: "GET",
                url: 'utils/update.php',
                dataType: "json",
                success: function (data) {
                    resolve(data) // Resolve promise and go to then()
                },
                error: function (err) {
                    reject(err) // Reject the promise and go to catch()
                }
            });
        });
    }
});