$(function() {
    // 編集ボタンクリック処理
    $('.edit-line').click(function() {
        $(this).parent().find('.edit-line').hide();
        $(this).parent().find('.save-line').show();
        $(this).parent().find('.cancel-line').show();
        $(this).parents('.data-edit').find("[class$='_value']").hide();
        $(this).parents('.data-edit').find("[class$='_change']").show();
    });
    // 保存ボタンクリック処理
    $('.save-line').click(function() {
        $(this).parent().find('.edit-line').show();
        $(this).parent().find('.save-line').hide();
        $(this).parent().find('.cancel-line').hide();
        $(this).parents('.data-edit').find("[class$='_value']").show();
        $(this).parents('.data-edit').find("[class$='_change']").hide();
    });
    // キャンセルボタンクリック処理
    $('.cancel-line').click(function() {
        $(this).parent().find('.edit-line').show();
        $(this).parent().find('.save-line').hide();
        $(this).parent().find('.cancel-line').hide();
        $(this).parents('.data-edit').find("[class$='_value']").show();
        $(this).parents('.data-edit').find("[class$='_change']").hide();
    });

    $("[class$='_value']").show();
    $("[class$='_change']").hide();
    $("[class$='save-line']").hide();
    $("[class$='cancel-line']").hide();
});