new Vue({
    el: '.app',
    data: {
        showList: true,
        urlList: false
    },

    methods: {
        viewContent: function () {
            var _this = this;
            _this.showList = false;
        }
    }
});