const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
  mode: 'development',
  entry: './src/index.js',
  output: {
    filename: 'main.js',
    path: path.resolve(__dirname, 'dist'),
    library: 'commentPlugin',
  },
  devtool: 'inline-source-map',
  devServer: {
    inline: false,
    contentBase: './dist',
  },
  module: {
    rules: [
      {
        tese: /\.css$/i,
        use: ['style-loader', 'css-loader'],
      }, {
        test: /\.s[ac]ss$/i,
        use: [
          'style-loader',
          'css-loader',
          'sass-loader',
        ],
      }, {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env'],
          },
        },
      },
    ],
  },
  plugin: [new HtmlWebpackPlugin()],
};
