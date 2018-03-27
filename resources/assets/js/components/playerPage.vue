<template>
    <div class="hello">
        <h1>PlayerPage</h1>
        <div class="panel-body">
                            <button type="button" @click="logOut" onclick="{location.href='http://127.0.0.1:8000'}">登出</button>
        </div>
    </div>
</template>
<script>
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
        
        async logOut() {
            await axios.post('logOut', {token: localStorage.token})
            .then(res => {
                console.log(res.data);
                if(res.data.ret === 0) {
                    this.isLogin = 'logOut';
                    localStorage.token = null;
                    alert('登出成功');
                }
            })
            .catch(ex => {

            });
            this.isChange = 'unchanged';
        },
        
    },

    mounted() {
    }
}
</script>

