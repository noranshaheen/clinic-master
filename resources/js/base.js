export default {
    methods: {
        __: function(key, replace = {}) {
            var translation = this.$page.props.language[key]
                ? this.$page.props.language[key]
                : key

            Object.keys(replace).forEach(function (key) {
                translation = translation.replace(':' + key, replace[key])
            });

            return translation
        },
        __n: function(key, number, replace = {}) { 
            var options = key.split('|');   

            key = options[1]; 
            if(number == 1) { 
                key = options[0]; 
            }   

            return tt(key, replace); 
        },
        parse(val) {
            var temp = parseFloat(val);
            if (isNaN(temp)) temp = 0;
            return temp;
        },
        approximate(val) {
            if (val > 1000000) {
                return (val / 1000000).toFixed(2) + ' ' + this.__('Million');
            } else if (val > 1000) {
                return (val / 1000).toFixed(2) + ' ' + this.__('Thousand');
            } else {
                return val;
            }
        },
    }
};