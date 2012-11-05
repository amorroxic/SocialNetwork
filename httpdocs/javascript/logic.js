(function() {
  var Logic;

  Logic = (function() {

    function Logic() {

      jQuery(".chosen").chosen();

      $('.chosen').bind('change', $.proxy(function(e) {
          var selected = $(e.currentTarget).val();
          if (selected == "") {
            $('#result').html('');
            return false;
          } else {
            this.fetchUserData(selected);
          }
      }, this));

      var slug = jQuery('#people-selector').val();
      if (slug != '') this.fetchUserData(slug);

    }

    Logic.prototype.fetchUserData = function(slug) {

      var myURL = "/user-data";
      var myParams = { 'slug': slug };

      var updateContainers = {
          "#result" : {"ajax":"content"}
      };

      this.ajaxQuery(myURL, myParams, updateContainers);

    };

    Logic.prototype.ajaxQuery = function(ajaxURL, ajaxParams, updateContainers) {
      jQuery.ajax({
        url: ajaxURL,
        type: "POST",
        data: ajaxParams,
        dataType: "json",
        context: this,
        success: function(data) {
          this.ajaxResult(data,updateContainers);
        },
        error: function(data) {
           alert('Sorry, the website is under heavy stress. Please try again later.');
        }
      });

    };

    Logic.prototype.ajaxResult = function(jsonResponse, updateContainers) {

      var mainContent;
      try {
        var response = jsonResponse;
        for (var container in updateContainers) {
          mainContent = jQuery(container);
          if (mainContent) {
            var ajaxResponse = updateContainers[container]["ajax"];
            mainContent.html(response[ajaxResponse]);
          }
        }
      } catch(error) {
        alert('Sorry, the website is under heavy stress. Please try again later [2].');
      }

    };

    return Logic;

  })();

  jQuery(document).ready(function() {
    return new Logic;
  });

}).call(this);
