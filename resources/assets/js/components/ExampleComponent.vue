<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div v-show="isLogin === 'notLogin'">
                        <div class="panel-heading">會員登入</div>
                        <div class="panel-body">
                            <label for="acc">
                                帳號：
                                <input type="text" v-validate="'required|alpha_num'"  id="acc" v-model="loginData.acc" name="loginAccount">
                                <span class="tip" v-show="errors.has('loginAccount') && fields.loginAccount.touched">格式不符</span>
                            </label>
                            <br>
                            <label for="psd">
                                密碼：
                                <input type="text" id="psd" v-model="loginData.psd"> 
                            </label>
                            
                            <button type="button" @click="login">登入</button>
                            <br>
                        </div>  
                        <div>
                            <button type="button" @click="checkToken" >按我顯示其他資訊 </button>
                            <br>
                        </div>
                    </div>
                    <div v-show="isLogin === 'login'">
                        只有登入後才可以看到我
                        <button type="button" @click="isLogin = 'notLogin'">返回</button>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data () {
        return {
        isLogin: 'notLogin',
        loginData: {
            acc: '',
            psd: '',
        },
        loginMsg: '',
        checkMsg: '',
        ID: '',
        memberList: [],
        selected: ''
        }
    },

    methods: {

        ///if XSRF-TOKEN not found refresh page ,and logout if is login
        async login() {
            let MD5 = require("crypto-js/md5");
            let psdArray = MD5(this.loginData.psd);
            let psd = psdArray.words[0].toString()+psdArray.words[1].toString()+psdArray.words[2].toString()+psdArray.words[3].toString();
            let loginData = {
                acc: this.loginData.acc,
                psd: psd
            }
            Object.keys(this.fields).forEach(key => {
					this.fields[key].touched = true;
            });
            const accResult = await this.$validator.validate('loginAccount');
            if (accResult === false) {
                return;
            }
            
            await axios.post('login', loginData)
            .then(res => {
                //document.cookie = "name = abc"+";"+"expires = expire_days=15000";  //cookie test
                console.log(res.data);
                if(res.data.ret === 0) {
                    alert('登入成功');
                    sessionStorage.token = res.data.token;
                    sessionStorage.id = res.data.id;
                } else {
                    alert('登入失敗');
                }
            })
            .catch(ex => {

            });
        },
        async checkToken() {
            await axios.post('token')
            .then(res => {
                console.log(res.data);
                if(res.data.ret == 0) {
                    if(res.data.status == '0'){
                        location.href='http://laravel.local/agentpage';
                    }
                    else{
                        location.href='http://localhost:8000/playerpage';
                    }
                }
            })
            .catch(ex => {

            });
            this.isChange = 'unchanged';
        },
        // checkCSRFTOKEN(){
        //     var XSRFTOKEN = this.getCookie('XSRF-TOKEN');
        //     console.log(XSRFTOKEN);
        //     if(XSRFTOKEN == "")
        //     {
        //         window.location.reload();
        //     }
        // },
        // getCookie(cname) {
        //     var name = cname + "=";
        //     var decodedCookie = decodeURIComponent(document.cookie);
        //     var ca = decodedCookie.split(';');
        //     for(var i = 0; i <ca.length; i++) {
        //         var c = ca[i];
        //         while (c.charAt(0) == ' ') {
        //             c = c.substring(1);
        //         }
        //         if (c.indexOf(name) == 0) {
        //             return c.substring(name.length, c.length);
        //         }
        //     }
        //     return "";
        // }
    },

    mounted() {
    }
}
</script>

