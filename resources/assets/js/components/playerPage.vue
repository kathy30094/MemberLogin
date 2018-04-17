<template>
    <div class="hello">
        <h1>PlayerPage</h1>
        <div class="panel-body">
            <button type="button" @click="logOut" onclick="{location.href='http://192.168.4.114'}">登出</button>
            
            <button type="button" @click="toChatroom">聊天</button>
        </div>

    </div>
</template>
<script>
window.name=sessionStorage.token;
import axios from 'axios'

export default {
    data () {
        return {
        isLogin: 'notLogin',
        loginMsg: '',
        checkMsg: '',
        ID: '',
        memberList: [],

        }
    },

    methods: {
        async toChatroom() {
            window.location="http://localhost:3000";

        },
        async logOut() {
            this.checkCSRFTOKEN();
            await axios
                .post("logOut", )
                .then(res => {
                console.log(res.data);
                if (res.data.ret == 0) {
                    this.isLogin = "logOut";
                    sessionStorage.clear();
                    localStorage.clear();
                    alert("登出成功");
                location.href='http://192.168.4.114';
                }
            })
            .catch(ex => {});

        },
        
    },

    mounted() {
    }
}
</script>

