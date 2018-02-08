new Vue({
    el: '.app',
    data: {
        isShowPredict:false,
        search: $('#s').val(),
        results: [],
    },


    methods: {
        predict: function(search) {
                var _this = this;
                _this.results = [];
                _this.isShowPredict = true;
                search = $('#s').val();
                this.$http.get('http://homestead.test/api/predict/' + search.trim()).then(function (response) {
                    for (var i=0;i<response.body.length;i++) {
                        for (var j = 0; j < response.body[i].length; j++) {
                            if (response.body[i][j] !== "") {
                                console.log(typeof(_this.results));
                                _this.results.push(response.body[i][j]);
                            }
                        }
                    }
                    console.log(_this.results);
                })
        },
    }
});