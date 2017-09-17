var path = require('path')
var webpack = require('webpack')

var configs = [
    {
        name: 'config:public',
        entry: {
            public : './resources/js/public-spa/main.js',
        },
        output: {
            path: path.resolve(__dirname, './public/public-spa/dist'),
            publicPath: './public/public-spa/dist/',
            filename: 'public.build.js',
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                        loaders: {
                            'scss': 'vue-style-loader!css-loader!sass-loader',
                            'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax'
                        }
                    }
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/
                },
                {
                    test: /\.(png|jpg|gif|svg)$/,
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]?[hash]'
                    }
                }
            ]
        },
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js'
            }
        },
        devServer: {
            contentBase: './public/public-spa/',
            historyApiFallback: {
                rewrites: [
                    { from: /^\/$/, to: 'build.html' },
                ],
            },
            noInfo: true,
            hot: true,
            open: true,
            port: 8095
        },
        performance: {
            hints: false
        },
        devtool: '#eval-source-map'
    },
    {
        name: 'config:admin',
        entry: {
            public : './resources/js/admin-spa/main.js',
        },
        output: {
            path: path.resolve(__dirname, './public/admin-spa/dist'),
            publicPath: './public/admin-spa/dist/',
            filename: 'admin.build.js'
        },
        module: {
            rules: [
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: {
                        loaders: {
                            'scss': 'vue-style-loader!css-loader!sass-loader',
                            'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax'
                        }
                    }
                },
                {
                    test: /\.js$/,
                    loader: 'babel-loader',
                    exclude: /node_modules/
                },
                {
                    test: /\.(png|jpg|gif|svg)$/,
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]?[hash]'
                    }
                }
            ]
        },
        resolve: {
            alias: {
                'vue$': 'vue/dist/vue.esm.js'
            }
        },
        devServer: {
            contentBase: './public/admin-spa/',
            historyApiFallback: {
                rewrites: [
                    { from: /^\/$/, to: 'build.html' },
                ],
            },
            noInfo: true,
            hot: true,
            open: true,
            port: 8096
        },
        performance: {
            hints: false
        },
        devtool: '#eval-source-map'
    }
];

if (process.env.NODE_ENV === 'development-admin') {
    for (const project of configs) {
        if(project.name === 'config:admin'){
            module.exports = project;
        }
    }
}

if (process.env.NODE_ENV === 'development-public') {
    for (const project of configs) {
        if(project.name === 'config:public'){
            module.exports = project;
        }
    }
}

if (process.env.NODE_ENV === 'development') {
    module.exports = configs;
}

if (process.env.NODE_ENV === 'production') {
    for (const project of configs) {
        project.devtool = '#source-map'
        project.plugins = (project.plugins || []).concat([
            new webpack.DefinePlugin({
                'process.env': {
                    NODE_ENV: '"production"'
                }
            }),
            new webpack.optimize.UglifyJsPlugin({
                sourceMap: false,
                compress: {
                    warnings: false,
                },
                output: {
                    comments: false,
                },
            }),
            new webpack.LoaderOptionsPlugin({
                minimize: true
            })
        ])
        module.exports = configs;
    }
}