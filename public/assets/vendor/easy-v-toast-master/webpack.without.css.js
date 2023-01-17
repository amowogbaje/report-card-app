const path = require('path');

module.exports = {

    entry: './src/js/index.js',
    output: {
        filename: 'toast.without.css.js',
        path: path.resolve(__dirname, 'dist'),
    },
    mode: "production",
    module: {
        rules: [
            {
                test: /\.scss$/,
                exclude: /node_modules/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            outputPath: './',
                            name: 'toast.min.css'
                        }
                    },
                    'sass-loader'
                ]
            }
        ],
    },
};
