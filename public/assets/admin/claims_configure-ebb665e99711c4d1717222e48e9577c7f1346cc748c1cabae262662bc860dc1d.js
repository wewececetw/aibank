(function($, DataTable) {
  if (!DataTable.ext.editorFields) {
    DataTable.ext.editorFields = {};
  }

  var Editor = DataTable.Editor;
  var _fieldTypes = DataTable.ext.editorFields;

  _fieldTypes.slider_annual_interest_rate = {
    create: function(conf) {
      conf._enabled = true;
      conf._input = $(
        '<div id="slidecontainer' + Editor.safeId(conf.id) + '">' +
          '<input type="range" min="0" max="10" value="5" step="0.1" class="slider configureRiskSlider" disabled>' +
          '<span class="slider-value"></span>' +
        '</div>'
      );

      return conf._input;
    },

    get: function(conf) {
      return $('.configureRiskSlider')[0].value;
    }
  };

  _fieldTypes.slider_auto_close_threshold = {
    create: function(conf) {
      conf._enabled = true;
      conf._input = $(
        '<div id="slidecontainer' + Editor.safeId(conf.id) + '">' +
          '<input type="range" min="0" max="100" value="50" step="1" class="slider configureRiskSlider">' +
          '<span class="slider-value"></span>' +
        '</div>'
      );

      return conf._input;
    },

    get: function(conf) {
      return $('.configureRiskSlider')[1].value;
    }
  };
})(jQuery, jQuery.fn.dataTable);

$(document).ready(function() {
  var configure = new $.fn.dataTable.Editor({
    ajax: {
      url: '/admin/claims/update_row',
      type: 'PATCH'
    },
    table: "#claims_datatable",
    idSrc: "DT_RowId",
    fields: [
      {
        label: '物件編號',
        name: 'claim_number',
        type: 'readonly'
      },
      {
        label: '風險類別',
        name: 'risk_category',
        type: 'readonly'
      },
      {
        label: '年利率',
        name: 'annual_interest_rate',
        type: 'slider_annual_interest_rate',
      },
      {
        label: '自動結標',
        name: 'auto_close_threshold',
        type: 'slider_auto_close_threshold'
      },
      {
        label: '上架日',
        name: 'launched_at'
      },
      {
        label: '預計結標日',
        name: 'estimated_close_date'
      },
    ]
  });

  var table = $('#claims_datatable').DataTable();

  $('#claims_datatable').on('click', '.claims', function() {
    var dataId = $(this).attr('data-id');
    var currentRow = this.closest('tr');
    var currentId = table.row(currentRow).index();
    var claimRecord = CLAIMS_DATA.filter(function(claim) {
      return claim.DT_RowId == dataId;
    });

    configure
      .title('設定債權')
      .buttons('儲存')
      .edit(currentId, true);

    var sliders = document.getElementsByClassName('configureRiskSlider');
    var slider_names = ["annual_interest_rate", "auto_close_threshold"];

    if (/[A-E]/.test(claimRecord[0]['risk_category'])) {
      sliders[0].disabled = true;
    } else {
      sliders[0].disabled = false;
    }

    for (var i = 0; i < sliders.length; i++) {
      // set input slider text to current value from datatable
      sliders[i].value = claimRecord[0][slider_names[i]];
      sliders[i].nextSibling.innerHTML = claimRecord[0][slider_names[i]];
      sliders[i].oninput = function() {
        var sliderVal = this.nextSibling;
        sliderVal.innerHTML = this.value + '%';
      };
    };
  });
});
