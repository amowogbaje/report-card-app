const path = require('path');

module.exports = {

    entry: './src/js/index.js',
    output: {
        filename: 'toast.with.css.js',
        path: path.resolve(__dirname, 'dist'),
    },
    mode: "production",
    module: {
        rules: [
            {
                test: /\.scss$/i,
                use: ['style-loader', 'css-loader', 'sass-loader'],
            }
        ],
    },
};
