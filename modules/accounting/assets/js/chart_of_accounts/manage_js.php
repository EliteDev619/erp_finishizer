<script type="text/javascript">
  var list_account_type_details, fnServerParams;
  var next_account_num = <?php echo $account_next_id ?>;
  var account_data = <?php echo json_encode($accounts); ?>;
  var account_currency = <?php echo json_encode($account_currency); ?>;
  var select_acc_info = null;
  var last_selected_el = null;
  var acc_cnt = account_data.length;
  var account_tree_html = '<ul>';

  drawAccountTree(account_data);
  function drawAccountTree(param) {
    "use strict";
    acc_cnt = param.length;
    account_tree_html = "<ul>";
    var prefix = 1;
    if (param.length > 0) {
      for (let i = 0; i < acc_cnt; i++) {
        if (param[i]['parent_account'] == '0') {
          if (param[i]['is_leaf'] == 0) {
            account_tree_html += '<li><div onClick="selectAccount(this, true)"><span class="main glyphicon" id="' + param[i]['id'] + '"></span>'+ prefix + ' ' + param[i]['name'] + '</div><ul class="nested">'
            drawTree(param[i], param, prefix);
            account_tree_html += '</ul></li>'
            prefix++;
          }
          else if (param[i]['is_leaf'] == 1) {
            account_tree_html += '<li><div onClick="selectAccount(this)"><span class="glyphicon" id="' + param[i]['id'] + '"></span>'+ prefix + ' ' + param[i]['name'] + '</div></li>'
            prefix++;
          }
        }
      }

      account_tree_html += '</ul>';
      $('.account_treeview').html(account_tree_html);
    } else {
      account_tree_html += '</ul>';
      $('.account_treeview').html(account_tree_html);
    }
  }

  function drawTree(childData, param, paramPrefix) {
    var tempPrefix = 1;
    for (let j = 0; j < acc_cnt; j++) {
      if (childData['id'] == param[j]['parent_account']) {
        if (param[j]['is_leaf'] == 1) {
          account_tree_html += "<li><div onClick='selectAccount(this)'><span class='glyphicon' id='" + param[j]['id'] + "'></span>"+  ' '+ paramPrefix + tempPrefix+' ' + param[j]['name'] + "</div></li>";
          tempPrefix++
          continue;
        }
        account_tree_html += '<li><div onClick="selectAccount(this, true)"><span class="main glyphicon" id="' + param[j]['id'] + '"></span>' + paramPrefix + tempPrefix+' ' + param[j]['name'] +
          '</div><ul class="nested">';
        drawTree(param[j], param, paramPrefix.toString()+tempPrefix.toString());
        tempPrefix++
        account_tree_html += '</ul></li>'
      }
    }
  }

  function selectAccount(param, is_leaf = false) {
    if (last_selected_el) {
      last_selected_el.css("background-color", "#fff");
    }
    $(param).css("background-color", "rgb(185 185 191)");
    last_selected_el = $(param);
    if (is_leaf) {
      $($(param).children()[0]).toggleClass('main-down');
      $(param).next().toggleClass('active');
    }

    var select_acc_id = $($(param).children()[0]).attr('id');
    var select_acc = null;
    var BreakException = {};
    try {
      account_data.forEach(function (item) {
        if (item.id == select_acc_id) {
          select_acc = item;
          throw BreakException;
        }
      });
    } catch (e) {
      if (e !== BreakException) throw e;
    }

    select_acc_info = select_acc;
    if ($("#account-modal").hasClass("modal fade in")) {
      
      if($('input:radio[name=account_type]:checked').val()=='main'){
        $('input[name="parent_account_id"]').val('');
      } else {
        $('input[name=parent_account_id]').val(select_acc.id);
        var tempname = getParentAccountName(select_acc.parent_account, select_acc.name);
        if(select_acc.parent_account == 0){
          $('input[name=parent_account_text]').val(select_acc.name);
        } else {
          $('input[name=parent_account_text]').val(tempname);
        }
      }

    } else {
      reportAccount(select_acc);
    }
  }

  function reportAccount(select_acc) {

    $('input[name=report_account_no]').val(select_acc.id);
    $('input[name=report_account_name]').val(select_acc.name);

    var $radios = $('input:radio[name=report_account_type]');
    if (select_acc.parent_account == 0) {
      $radios.filter('[value=main]').prop('checked', true);
      $(".parent_account").addClass('hide');
      $(".report_sub_items").addClass('hide');
    } else {
      $radios.filter('[value=sub]').prop('checked', true);
      $(".parent_account").removeClass('hide');
      $(".report_sub_items").removeClass('hide');
      $('input[name=report_account_cost_center]').val(select_acc.cost_center);
      $('input[name=report_account_currency]').val(getCurrencyValue(select_acc.currency));
      $('input[name=report_account_category]').val(select_acc.category);

      var parent_account_text = getParentAccountName(select_acc.parent_account, select_acc.name);
      $('input[name=report_parent_account]').val(parent_account_text);
    }
  }

  function getParentAccountName(parentID, parentText) {
    for (var k = 0; k < account_data.length; k++) {
      if (account_data[k]['id'] == parentID) {
        parentText = account_data[k]['name'] + " >> " + parentText;
        if (account_data[k]['parent_account'] != 0) {
          return getParentAccountName(account_data[k]['parent_account'], parentText);
        } else {
          return parentText;
        }
      }
    }
  }

  function getCurrencyValue(id){
    for(var i=0; i<account_currency.length; i++){
      if(account_currency[i].id == id){
        return account_currency[i].name;
      }
    }
  }

  (function ($) {
    "use strict";

    appValidateForm($('#account-form'), {
      account_name: 'required',
    }, account_form_handler);

    function account_form_handler(form) {
      "use strict";
      var formURL = form.action;
      var formData = new FormData($(form)[0]);

      if(checkNameExist($('input[name="account_name"]').val())){
        alert_float('danger', 'Name is already exist! \n Please set another name!');
        return;
      }

      if($('input[name="account_type"]:checked').val() == 'sub' && $('input[name="parent_account_id"]').val()=='' && $('input[name="id"]').val()==''){
        alert_float('danger', 'Please select parent account!');
        return;
      }

      if($('input[name="account_type"]:checked').val() == 'sub' && $('input[name="parent_account_id"]').val() == $('input[name="id"]').val()){
        alert_float('danger', 'You can check your account as parent account!');
        return;
      }

      $.ajax({
        type: $(form).attr('method'),
        data: formData,
        mimeType: $(form).attr('enctype'),
        contentType: false,
        cache: false,
        processData: false,
        url: formURL
      }).done(function (response) {
        response = JSON.parse(response);
        if ($.isNumeric(response.success) || response.success == true) {
          alert_float('success', response.message);
          if ($.isNumeric(response.success)) {
            next_account_num = response.success + 1;
          }

          account_data = response.accounts;
          drawAccountTree(account_data);
        } else {
          alert_float('danger', response.message);
        }
        $('#account-modal').modal('hide');
      }).fail(function (error) {
        alert_float('danger', JSON.parse(error.mesage));
      });

      return false;
    }

    function checkNameExist(name){
      for(let i=0; i<account_data.length; i++)
      {
        if(name == account_data[i]['name'] && $('input[name="id"]').val() == ''){
          return true;
        }
      }
      return false;
    }

    $('.add-new-account').on('click', function () {
      $(".modal-title").html("<?php echo _l('Add new account'); ?>");
      $('input[name="id"]').val('');
      $('input[name="account_no"]').val(next_account_num);
      $('input[name="account_name"]').val('');
      $('input[name="parent_account_id"]').val('');

      var $radios = $('input:radio[name=account_type]');
      $radios.attr('disabled', false);
      $radios.filter('[value=main]').prop('checked', true);

      $(".modal_parent_account ").addClass('hide');
      $(".modal_sub_items").addClass('hide');
      $('#account-modal').modal('show');
    });

    $('.edit-account').on('click', function () {
      $(".modal-title").html("<?php echo _l('Edit account'); ?>");
      var $radios = $('input:radio[name=account_type]');

      if (select_acc_info == null) {
        alert_float('danger', 'Please select account!');
      } else {

        $('input[name="id"]').val(select_acc_info.id);
        $radios.attr('disabled', true);
        $('input[name="account_name"]').val(select_acc_info.name);
        $('input[name="account_no"]').val(select_acc_info.id);

        console.log(select_acc_info);
        if (select_acc_info.parent_account == 0) {
          $radios.filter('[value=main]').prop('checked', true);
          $('input[name="parent_account_id"]').val('');
          $('select[name="account_cost_center"]').val('');
          $('select[name="account_currency"]').val('');
          $('select[name="account_category"]').val('');
          $(".modal_parent_account ").addClass('hide');
          $(".modal_sub_items").addClass('hide');
        } else {
          $radios.filter('[value=sub]').prop('checked', true);
          $(".modal_parent_account ").removeClass('hide');
          $(".modal_sub_items").removeClass('hide');
          $('select[name="account_cost_center"]').val(select_acc_info.cost_center).change();
          $('select[name="account_currency"]').val(select_acc_info.currency).change();
          $('select[name="account_category"]').val(select_acc_info.category).change();

          var parent_account_text = getParentAccountName(select_acc_info.parent_account, select_acc_info.name);
          $('input[name=parent_account_text]').val(parent_account_text);
        }

        $('#account-modal').modal('show');
      }
    });

    $('.delete-account').on('click', function () {
      if (select_acc_info == null) {
        alert_float('danger', 'Please select account!');
      } else {
        if (select_acc_info.is_leaf == 0) {
          if (confirm('If you remove this account, this children accounts will be blocked. \n Are you sure?')) {
            requestGetJSON(admin_url + 'accounting/delete_account/' + select_acc_info.id).done(function (response) {
              if (response.success) {
                alert_float('success', 'Account deleted successfully!');
                account_data = response.accounts;
                drawAccountTree(account_data);
              } else {
                alert_float('danger', 'Failed');
              }
            });
          }
        } else {
          if (confirm('Are you sure?')) {
            requestGetJSON(admin_url + 'accounting/delete_account/' + select_acc_info.id).done(function (response) {
              if (response.success) {
                alert_float('success', 'Account deleted successfully!');
                account_data = response.accounts;
                drawAccountTree(account_data);
              } else {
                alert_float('danger', 'Failed');
              }
            });
          }
        }
      }
    });

    $('input[type=radio][name=account_type]').change(function () {
      if (this.value == 'sub') {
        $('input[name="account_name"]').val('');
        $('input[name="parent_account_id"]').val('');
        $(".modal_parent_account").removeClass('hide');
        $(".modal_sub_items").removeClass('hide');
      }
      else {
        $(".modal_parent_account").addClass('hide');
        $(".modal_sub_items").addClass('hide');
      }
    });


    //   $.ajax({
    //     type: 'post',
    //     data: {
    //       'delete_id':select_acc_info.id,
    //     },
    //     url: admin_url + 'accounting/delete_account',
    //   }).done(function (response) {
    //     response = JSON.parse(response);
    //     console.log(response)
    //   }).fail(function (error) {
    //     alert_float('danger', 'failed');
    //   });
    // }
    // function expendAccountTree(id){
    //   var selected_el = $("[id="+id+"]", ".modal_parent_account");
    //   selected_el.parent().css('background-color',"rgb(185 185 191)")
    //   selected_el.parent().parent().parent().addClass('active')
    //   $(selected_el.parent().parent().parent().prev().children()[0]).addClass('main-down')
    // }




    var html = '';
    var note = 0;
    $.each(list_account_type_details, function (index, value) {
      if (value.account_type_id == $('select[name="account_type_id"]').val()) {
        if (note == 0) {
          $('#detail_type_note').val(value.note);
          note = 1;
        }
        html += '<option value="' + value.id + '">' + value.name + '</option>';
      }
    });

    $('select[name="account_detail_type_id"]').html(html);
    $('select[name="account_detail_type_id"]').selectpicker('refresh');

    $.each(list_account_type_details, function (index, value) {
      if (value.id == $('select[name="account_detail_type_id"]').val()) {
        $('.detail_type_note').html(value.note);
      }
    });

    init_account_table();

    $('select[name="account_type_id"]').on('change', function () {

      if ($(this).val() <= 10 && $(this).val() != 1 && $(this).val() != 6 && $('input[name="id"]').val() == '') {
        $('#div_balance').removeClass('hide');
      } else {
        $('#div_balance').addClass('hide');
      }

      var html = '';
      var note = 0;
      $.each(list_account_type_details, function (index, value) {
        if (value.account_type_id == $('select[name="account_type_id"]').val()) {
          if (note == 0) {
            $('#detail_type_note').val(value.note);
            note = 1;
          }
          html += '<option value="' + value.id + '">' + value.name + '</option>';
        }
      });

      $('select[name="account_detail_type_id"]').html(html);
      $('select[name="account_detail_type_id"]').selectpicker('refresh');

      $.each(list_account_type_details, function (index, value) {
        if (value.id == $('select[name="account_detail_type_id"]').val()) {
          $('.detail_type_note').html(value.note);
        }
      });
    });

    $('select[name="account_detail_type_id"]').on('change', function () {
      $.each(list_account_type_details, function (index, value) {
        if (value.id == $('select[name="account_detail_type_id"]').val()) {
          $('.detail_type_note').html(value.note);
        }
      });
    });

    $("input[data-type='currency']").on({
      keyup: function () {
        formatCurrency($(this));
      },
      blur: function () {
        formatCurrency($(this), "blur");
      }
    });

    $('input[name="mass_activate"]').on('change', function () {
      if ($('#mass_activate').is(':checked') == true) {
        $('#mass_delete').prop("checked", false);
        $('#mass_deactivate').prop("checked", false);
      }
    });

    $('input[name="mass_deactivate"]').on('change', function () {
      if ($('#mass_deactivate').is(':checked') == true) {
        $('#mass_delete').prop("checked", false);
        $('#mass_activate').prop("checked", false);
      }
    });

    $('input[name="mass_delete"]').on('change', function () {
      if ($('#mass_delete').is(':checked') == true) {
        $('#mass_activate').prop("checked", false);
        $('#mass_deactivate').prop("checked", false);
      }
    });

  })(jQuery);

  function edit_account(id) {
    "use strict";
    $('#account-modal').find('button[type="submit"]').prop('disabled', false);

    requestGetJSON(admin_url + 'accounting/get_data_account/' + id).done(function (response) {
      $('#account-modal').modal('show');

      $('select[name="account_type_id"]').val(response.account_type_id).change();
      $('select[name="account_detail_type_id"]').val(response.account_detail_type_id).change();
      if (response.parent_account != 0) {
        $('select[name="parent_account"]').val(response.parent_account).change();
      } else {
        $('select[name="parent_account"]').val('').change();
      }
      $('input[name="number"]').val(response.number);
      $('input[name="name"]').val(response.name);
      $('input[name="id"]').val(id);
      $('input[name="balance"]').val(response.balance);
      $('input[name="balance_as_of"]').val(response.balance_as_of);

      if (response.description != null) {
        tinyMCE.activeEditor.setContent(response.description);
      } else {
        tinyMCE.activeEditor.setContent('');
      }
      $('textarea[name="description"]').val(response.description);
      if (response.balance > 0) {
        $('input[name="update_balance"]').val(0);
        $('#div_balance').addClass('hide');
      } else {
        $('input[name="update_balance"]').val(1);
        $('#div_balance').removeClass('hide');
      }
    });
  }

  function formatNumber(n) {
    "use strict";
    // format number 1000000 to 1,234,567
    return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
  }
  function formatCurrency(input, blur) {
    "use strict";
    // appends $ to value, validates decimal side
    // and puts cursor back in right position.

    // get input value
    var input_val = input.val();

    // don't validate empty input
    if (input_val === "") { return; }

    // original length
    var original_len = input_val.length;

    // initial caret position
    var caret_pos = input.prop("selectionStart");

    // check for decimal
    if (input_val.indexOf(".") >= 0) {

      // get position of first decimal
      // this prevents multiple decimals from
      // being entered
      var decimal_pos = input_val.indexOf(".");

      // split number by decimal point
      var left_side = input_val.substring(0, decimal_pos);
      var right_side = input_val.substring(decimal_pos);

      // add commas to left side of number
      left_side = formatNumber(left_side);

      // validate right side
      right_side = formatNumber(right_side);

      // Limit decimal to only 2 digits
      right_side = right_side.substring(0, 2);

      // join number by .
      input_val = left_side + "." + right_side;

    } else {
      // no decimal entered
      // add commas to number
      // remove all non-digits
      input_val = formatNumber(input_val);
      input_val = input_val;

    }

    // send updated string to input
    input.val(input_val);

    // put caret back in the right position
    var updated_len = input_val.length;
    caret_pos = updated_len - original_len + caret_pos;
    input[0].setSelectionRange(caret_pos, caret_pos);
  }

  function init_account_table() {
    "use strict";

    if ($.fn.DataTable.isDataTable('.table-accounts')) {
      $('.table-accounts').DataTable().destroy();
    }
    initDataTable('.table-accounts', admin_url + 'accounting/accounts_table', [0], [0, 1, 2, 3, 4, 5, 6, 7, 8], fnServerParams, []);
    $('.dataTables_filter').addClass('hide');
  }

  // journal entry bulk actions action
  function bulk_action(event) {
    "use strict";
    if (confirm_delete()) {
      var ids = [],
        data = {};
      data.mass_delete = $('#mass_delete').prop('checked');
      data.mass_activate = $('#mass_activate').prop('checked');
      data.mass_deactivate = $('#mass_deactivate').prop('checked');

      var rows = $($('#accounts_bulk_actions').attr('data-table')).find('tbody tr');

      $.each(rows, function () {
        var checkbox = $($(this).find('td').eq(0)).find('input');
        if (checkbox.prop('checked') === true) {
          ids.push(checkbox.val());
        }
      });
      data.ids = ids;

      $(event).addClass('disabled');
      setTimeout(function () {
        $.post(admin_url + 'accounting/accounts_bulk_action', data).done(function () {
          window.location.reload();
        });
      }, 200);
    }
  }
</script>