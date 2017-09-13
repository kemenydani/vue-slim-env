import axios from 'axios';

var userResource = axios.create({

});

userResource.all = function(){
    return this.get('users');
}

export { userResource }