To use to the api into your project, please copy over all files below in the right folder, if the folders do not exist. Create them yourself in the as shown folder structure.

After that apply these changes.


Change the lines in your config.js file, these values are unique and should be different for your application!

module.exports = {
    daVinciAuthValidateUrl: "http://vm:1337/Sso/ValidateAuth/0fc947b9-d986-4147-8e57-a0ca05b9d0c3/",
    daVinciAuthKey: "NodeJSExpressAppSecret",
    daVinciAuthNotAuthorizedRedirectUrl: "/"
};

And add these lines to the package.json
“dependencies”: {
    "jsonwebtoken": "^7.1.9",
    "request": "^2.79.0",
},
(Don’t recreate the depencencies key if it exists already, simply just add the lines inside)

Run npm install to install the missing dependencies

Now to use the api, use the following code as an example.

index.js (Route file)

var express = require('express');
var daVinciAuth = require('../modules/daVinciAuth');
var router = express.Router();

/* GET home page. */
router.get('/', function(req, res, next) {
  res.render('index', { title: 'Express' });
});

router.get('/account', daVinciAuth.middleware, function (req, res) {
  res.render('account', { user: req.daVinciAuthUser });
});

router.get('/loginCallback', function (req, res) {
  daVinciAuth.login(req, res);
});

router.get('/logout', function (req, res) {
  daVinciAuth.logout(req, res);
  res.redirect('/');
});

module.exports = router;