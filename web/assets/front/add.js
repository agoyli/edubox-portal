$(document).ready(function () {
    // Ace editor
    if (typeof ace !== 'undefined') {
        var editor = ace.edit("ace-editor");
        editor.session.setMode("ace/mode/python");
        editor.setTheme("ace/theme/monokai");
        var textarea = $('#code_submit_code').hide();
        editor.session.setValue(textarea.val());
        editor.session.on('change', function(){
            $('#code_submit_code').val(editor.session.getValue());
        });
        $("#code_submit_language").on('change', function () {
            var lang = $(this).val();
            var aceLangs = {
                1:'text', 2:'c_cpp', 3:'csharp',
                4:'clojure', 5:'crystal', 6:'elixir',
                7:'erlang', 8:'golang', 9:'haskell',
                10:'java', 11:'javascript', 12:'ocaml',
                13:'pascal', 14:'python', 15:'ruby',
                16:'rust'
            };
            var selectLangs = {
                1:1, 2:1, 3:1, 4:2, 5:2, 6:2, 7:2, 8:2, 9:2,
                10:2, 11:2, 12:2, 13:2, 14:2, 15:2, 16:3,
                17:3, 18:4, 19:5, 20:6, 21:7, 22:8, 23:9,
                24:9, 25:1, 26:10, 27:10, 28:10, 29:11, 30:11,
                31:12, 32:1, 33:13, 34:14, 35:14, 36:14, 37:14,
                38:15, 39:15, 40:15, 41:15, 42:16, 43:1, 44:1
            };
            var newLang = aceLangs[selectLangs[lang]];
            editor.session.setMode("ace/mode/"+newLang);
        });
    }

    $("form#code_submit").submit(function(e) {
        e.preventDefault();
        $("#code_submit_box .overlay").show();
        $("#submission_box").show();
        $("html, body").animate({ scrollTop: $('#submission_box').offset().top }, 1000);
        $("#code_submit_submit").attr('disabled', true);
        window.submissionEnded = false;
        updateSubmission();
    });

    // Code submit
    window.submissionEnded = true;
    window.execution_row_count = 0;

    $("#code_submit_reset").on('click', function () {
        $(this).hide();
        $("#code_submit_submit").attr('disabled', false);
    });
});

function updateSubmission() {
    if (window.submissionEnded) {
        console.log('TERMINATE updateSubmission');
        return;
    }
    var formSerialize = $("form#code_submit").serialize();
    var url = window.location.href;
    var executionRow = $(".execution-result").eq(window.execution_row_count);
    $.post(url, formSerialize, function(response) {
        console.log('Response: ', response);
        if (typeof response['status'] === 'undefined' || typeof response['submission']['id'] === 'undefined' || response['status'] < 1) {
            console.log('Error: '+response['text']);
            window.submissionEnded = true;
            return;
        }

        console.log(response['submission']['id']);
        if ($("#code_submit_submission").val() < 1)
            $("#code_submit_submission").val(response['submission']['id']);


        if (response['status'] === 1) {
            console.log('STATUS: Processing...');
        }
        else if (response['status'] === 2) {
            console.log('STATUS: Next test...');
            setExecution(executionRow, response['submission']['stdout'], response['submission']['status'], response['submission']['time'], response['submission']['memory']);
            addExecution(response['new_submission']['test_id'], response['new_submission']['test_input'], response['new_submission']['test_output'])
        }
        else if (response['status'] === 3) {
            window.submissionEnded = true;
            console.log('STATUS: All tests ended.');
            setExecution(executionRow, response['submission']['stdout'], response['submission']['status'], response['submission']['time'], response['submission']['memory']);
            if (response['submission']['status'] === 3) {
                $("#code_submit").prepend(
                    '<div class="callout callout-success">' +
                    '<h4><i class="icon fa fa-check"></i> Mesele çözüldi!</h4>' +
                    '</div>'
                );
            }
            else {
                $("#code_submit").prepend(
                    '<div class="callout callout-warning">' +
                    '<h4><i class="icon fa fa-warning"></i> Ýalňyşlyk bar!</h4>' +
                    (response['submission']['status'] !== '' ? '<p>Status: '+getStatus(response['submission']['status'])+'</p>': '') +
                    (response['submission']['stderr'] !== '' && response['submission']['stderr'] != null ? '<p>'+response['submission']['stderr']+'</p>' : '') +
                    '</div>'
                );
            }
            $("html, body").animate({ scrollTop: $('#code_submit').offset().top }, 1000);
            $("#code_submit_box .overlay").hide();
            $("#code_submit_reload").show();
        }
        else {
            console.log('STATUS: Get submission result error');
        }
    }, 'JSON').done(function() {
        setTimeout(updateSubmission, 1000);
    });
}

function addExecution(testId, input, output) {
    window.execution_row_count += 1;
    $("#submission_box .table tbody").append(
        "<tr class='execution-result'>" +
        "<td class='execution-test' data-id='"+testId+"'>"+(window.execution_row_count+1)+"</td>" +
        "<td class='execution-input'><pre>"+input+"</pre></td>" +
        "<td class='execution-expected'><pre>"+output+"</pre></td>" +
        "<td class='execution-output'><i class='fa fa-refresh fa-spin'></i></td>" +
        "<td class='execution-time'></td>" +
        "<td class='execution-memory'></td>" +
        "<td class='execution-status'></td>" +
        "</tr>"
    );
}

function setExecution(executionRow, output, status, time, memory) {
    executionRow.children(".execution-output").html("<pre>"+output+"</pre>");
    executionRow.children(".execution-status").html(getStatus(status));
    executionRow.children(".execution-time").html(time+" s");
    executionRow.children(".execution-memory").html(memory/1024+" mb");
}

function getStatus(id) {
    switch (id) {
        case 1: return "In Queue";
        case 2: return "Processing";
        case 3: return "Accepted";
        case 4: return "Wrong Answer";
        case 5: return "Time Limit Exceeded";
        case 6: return "Compilation Error";
        case 7: return "Runtime Error (SIGSEGV)";
        case 8: return "Runtime Error (SIGXFSZ)";
        case 9: return "Runtime Error (SIGFPE)";
        case 10: return "Runtime Error (SIGABRT)";
        case 11: return "Runtime Error (NZEC)";
        case 12: return "Runtime Error (Other)";
        case 13: return "Internal Error";
        case 14: return "Exec Format Error";
    }
    return "Unknown status";
}
