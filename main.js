$(document).ready(function()
{
    readCustomers();
});


function randomNumber()
{
    return Math.floor((Math.random() * 10000) + 1);
}

function readCustomers()
{
    var readcustomer = "readcustomer";

    $.ajax(
    {
        url:"backendfirst.php",
        type:"post",
        data:{ readcustomer : readcustomer},
        success:function(data,status)
        {
           $('#customers_contant').html(data);
        }
    });

};

function addCustomers()
{
    var titel = $('#titel').val();
    var firstname = $('#firstname').val();
    var lastname = $('#lastname').val();
    var email = $('#email').val();
    var mobile = $('#mobile').val();
    var address = $('#address').val();

    if ( false ) // false for random names, true for to enter your own data. 
    {
        $.ajax(
            {
                url:"backendfirst.php",
                type:"post",
                data:{
                    titel : titel,
                    firstname : firstname,
                    lastname : lastname,
                    email : email,
                    mobile : mobile,
                    address : address
                },
                success:function(data,status)
                {
                    readCustomers();
                }
            });
    }
    else
    {
        var titleArr = new Array( "Herr", "Frau" );
        var forNamesArr = new Array( "Jeff", "Teddy", "Stewart", "Bill", "Steve", "Scarlett", "Sebastian", "Alexander", "Ronald", "Marius", "Nico", "Emma", "Melissa", "Gal", "Elena","Peter", "Britney" );
        var lastNameArr = new Array( "Parker", "Chase", "Gale", "Gates", "Jobs", "Johansson", "Kurz", "Gadot", "Berry", "Kurz", "Gadot", "Parker", "Spears","Morgan", "Jenner" );
    
        for ( var i= 0; i < 100; i++ ) // for 100 Customers
        {
    
            titel = titleArr[ randomNumber() % titleArr.length ];
            firstname = forNamesArr[ randomNumber() % forNamesArr.length ];
            lastname = lastNameArr[ randomNumber() % lastNameArr.length ];
            email = randomNumber().toString() + "@domain.com";
            mobile = "+43" + randomNumber();
            address = randomNumber();
            $.ajax(
            {
                url:"backendfirst.php",
                type:"post",
                data:{
                    titel : titel,
                    firstname : firstname,
                    lastname : lastname,
                    email : email,
                    mobile : mobile,
                    address : address
                },
                success:function(data,status)
                {
                    readCustomers();
                }
            });
        }
    }
};

function DeleteCustomer(deleteID)
{
    var conf = confirm("Are you sure you want to delete this client?");
    if(conf == true)
    {
        $.ajax(
        {
            url:"backendfirst.php",
            type:"post",
            data:{deleteID : deleteID},
            success:function(data,status)
            {
                readCustomers();
            }
        });
    }
};


function GetUserDetail(id)
{
    $('#hidden_user_id').val(id);

    $.post("backendfirst.php",
    {
        id:id
    },  function(data,status)
    {
        var user = JSON.parse(data);
        $('#update_titel').val(user.titel);
        $('#update_firstname').val(user.firstname);
        $('#update_lastname').val(user.lastname);
        $('#update_email').val(user.email);
        $('#update_mobile').val(user.mobile);
        $('#update_address').val(user.address);
    });
    $('#update_user_modal').modal("show");
};

function updateUserDetail()
{
    var updtitel = $('#update_titel').val();
    var updfirstname = $('#update_firstname').val();
    var updlastname = $('#update_lastname').val();
    var updemail = $('#update_email').val();
    var updmobile = $('#update_mobile').val();
    var updaddress = $('#update_address').val();

    var hidden_user_updid = $("#hidden_user_id").val();

    $.post("backendfirst.php", 
    {
        hidden_user_updid : hidden_user_updid,
        updtitel : updtitel,
        updfirstname : updfirstname,
        updlastname : updlastname,
        updemail : updemail,
        updmobile : updmobile,
        updaddress : updaddress,
    },
    function(data,status)
    {
        $('#update_user_modal').modal("hide");
        readCustomers();
    })
};
