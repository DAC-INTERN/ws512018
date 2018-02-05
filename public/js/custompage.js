new Vue({
    el: '.app',
    data: {
        predictString : ''
    },

    methods: {
        predict: function (text) {
            var _this = this;
            this.predictString = text;
        }
    }
});