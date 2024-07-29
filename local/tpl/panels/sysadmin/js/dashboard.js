$(document).on("click", ".serverBtn", function () {
    serverGroup = $(this).data("id");
    if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $(this).removeClass("bg-blue-200");
        $(this).addClass("hover:bg-green-200");
        $(document).find('#server-group-' + serverGroup).fadeOut(800);
    } else {
        $(this).addClass("active");
        $(this).addClass("bg-blue-200");
        $(this).removeClass("hover:bg-green-200");
        $(document).find('#server-group-' + serverGroup).fadeIn(800);
    }
    console.log(serverGroup);
});

$().ready(function () {
    console.log('ready');

    var app = new Vue({
            el: '#app',
            data: {}
        },
        Vue.component('server-btn', {
            data: {
                serverButtons: [
                    {
                        name: 'Servidors principals',
                        class: 'bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn'
                    },
                    {
                        name: 'Servidors Web',
                        class: 'bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn'
                    },
                    {
                        name: 'Servidors Correu',
                        class: 'bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn'
                    },
                    {
                        name: 'Servidors Dedicats',
                        class: 'bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn'
                    },
                    {
                        name: 'Servidors Virtuals',
                        class: 'bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn'
                    },
                    {
                        name: 'Servidors Xen',
                        class: 'bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn'
                    }
                ]
            },
            template: '<button data-id="" class="bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn">Button</button>'
        }))

});

function loadGroup($group) {
    $.ajax({
        url: 'https://api.joind.in/v2.1/talks/10889',
        data: {
            format: 'json'
        },
        type: 'GET',
        dataType: 'jsonp',
        success: function (data) {
            var $title = $('<h1>').text(data.talks[0].talk_title);
            var $description = $('<p>').text(data.talks[0].talk_description);
        },
        error: function () {
            $('#info').html('<p>An error has occurred</p>');
        },
    });
}

function renderWidget(widget) {

}

function renderServerButton(button) {
    groupName = "Grupo";
    return '<button data-id="1" class="bg-white text-gray-800 font-semibold py-2 px-4 m-2 border border-gray-400 rounded shadow serverBtn">' + groupName + '</button>';
}