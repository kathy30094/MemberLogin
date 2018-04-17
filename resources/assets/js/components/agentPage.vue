<template>
  <div class="hello">
    <h1>Agent {{theID}}</h1>

    <!-- logout button -->
    <button type="button" @click="logOut" onclick="{location.href='http://192.168.4.114:8080'}">登出</button>

    <button type="button" @click="toChatroom">聊天</button>

    <div class="newMember">
      <h2>新增</h2>   

      <label for="acc">
        帳號：
        <input type="text" id="acc" v-model="memberData.acc" name="acc" >
        <span class="newMemberInput" v-show="errors.has('acc') && fields.acc.touched">格式不符</span>
      </label>
      <br>

      <label for="psd">
        密碼：
        <input type="password" id="psd" v-model="memberData.psd" name="psd" v-validate="'alpha_num'">
        <span class="newMemberInput" v-show="errors.has('psd') && fields.psd.touched">格式不符</span>
      </label> 
      <br>
     
      <label for="name">
        名稱：
        <input type="text" id="name" v-model="memberData.name" name="name" v-validate="'required|alpha_num'">
        <span class="newMemberInput" v-show="errors.has('name') && fields.name.touched">格式不符</span>
      </label>
      <br>

      <label for="phone">
        電話：
        <input type="text" id="phone" v-model="memberData.phone" name="phone"  v-validate="{regex: /^[0]{1}[0-9]{1}[0-9]{7,8}$/ }">
        <span class="newMemberInput" v-show="errors.has('phone') && fields.phone.touched">格式不符</span>
      </label>
      
      <br>

      <label for="email">
        信箱：
        <input type="text" id="email" v-model="memberData.email" name="email" v-validate="'email'">
      </label>
      <span class="newMemberInput" v-show="errors.has('email') && fields.email.touched">格式不符</span>
      <br>

      <input type="radio" v-model="memberData.status" value='0' /><label>代理</label>
      <input type="radio" v-model="memberData.status" value='1' /><label>玩家</label>
      
      <br>
      <button type="button" @click="newMember">新增成員</button>
      
    </div>  <!-- end class newMember -->
    
    <div class = "searchMembers">
      <h2>查詢</h2>

      <label for="ID">
        ID：
        <input type="text" id="ID" v-model="searchDatas.ID">
      </label>
      <br>

      <input type="radio" v-model="searchDatas.selected" value=0 @change="show"/><label>代理</label>
      <input type="radio" v-model="searchDatas.selected" value=1 @change="show"/><label>玩家</label>
      <input type="radio" v-model="searchDatas.selected" value=3 @change="show"/><label>全部</label>
      <button type="button" @click="search">搜尋客戶</button>
    
      <table>           <!-- show searchMember in list bellow-->
        <tr>
          <!-- <th>編號</th> -->
          <th>ID</th>
          <th>帳號</th>
          <th>姓名</th>
          <th>電話</th>
          <th>信箱</th>
          <th>身份</th>
        </tr>

        <tr v-for="(member, index) in chosedMemberList">
          <!-- <td>{{index}}</td> -->
          <td>{{member.id}}</td>
          <td>{{member.Account}}</td>
          <td>{{member.Name}}</td>
          <td>{{member.Phone}}</td>
          <td>{{member.Email}}</td>
          <td>{{member.Status == 0 ? '代理' : '玩家'}}</td>
          <td><button type="button" @click="toUpdate(member)">編輯</button></td>
          <td><button type="button" @click="deleteMember(member)">刪除</button></td>
        </tr>
      </table>
      
      <div v-show="toModified === 'modified'"><!-- 按下member table 中的編輯按鈕-->
        <label for="psdUpdate">
            密碼：
            <input type="text" id="psdUpdate" v-model="updateData.psd" name="psdUpdate" v-validate="'alpha_num'">
            <span class="memberUpdate" v-show="errors.has('psdUpdate') && fields.psdUpdate.touched">格式不符</span>
        </label>
         <br>

        <label for="nameUpdate">
            名稱：
            <input type="text" id="nameUpdate" v-model="updateData.name" name="nameUpdate" v-validate="'alpha_num'">
            <span class="memberUpdate" v-show="errors.has('nameUpdate') && fields.nameUpdate.touched">格式不符</span>
        </label>
         <br>

        <label for="phoneUpdate">
            電話：
            <input type="text" id="phoneUpdate" v-model="updateData.phone" name="phoneUpdate" v-validate="{regex: /^[0]{1}[0-9]{1}[0-9]{7,8}$/ }">
            <span class="memberUpdate" v-show="errors.has('phoneUpdate') && fields.phoneUpdate.touched">格式不符</span>
        </label>
         <br>

        <label for="emailUpdate">
            信箱：
            <input type="text" id="emailUpdate" v-model="updateData.email" name="emailUpdate" v-validate="'email'">
            <span class="memberUpdate" v-show="errors.has('emailUpdate') && fields.emailUpdate.touched">格式不符</span>
        </label>     
         <br>   

        <button type="button" @click="updateMember">修改</button>
      </div><!-- end <div v-show="toModified === 'modified'"> -->
    </div> <!--end class searchMembers -->

  </div> <!-- end class hello -->
</template>

<script>
window.name=sessionStorage.token;
import axios from "axios";

export default {
  data() {
    return {
      loginMsg: "",
      checkMsg: "",
      toModified: "no",
      memberList: [],
      retrievedMemberList: [],
      chosedMemberList: [],
      theID: sessionStorage.id,
      memberData: {
        acc: "",
        psd: "",
        name: "",
        phone: "",
        email: "",
        status: "0",
      },
      updateData: {
        psd: "",
        name: "",
        phone: "",
        email: "",
      },
      searchDatas: {
        ID: "",
        selected: "3",
      },
    };
  },

  methods: {
    async toChatroom() {
      window.location="http://localhost:10001";
    },


    //logout
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
            location.href='http://192.168.4.114:8080';
          }
        })
        .catch(ex => {});
        //
    },

    //update
    async updateMember() {  
      let MD5 = require("crypto-js/md5");
      let psdArray = MD5(this.updateData.psd);
      let psd = psdArray.words[0].toString()+psdArray.words[1].toString()+psdArray.words[2].toString()+psdArray.words[3].toString();
      let updateData = {
          id: sessionStorage.idToUpdate,
          psd: psd,
          name: this.updateData.name,
          phone: this.updateData.phone,
          email: this.updateData.email,
      };
      this.checkCSRFTOKEN();
      await axios
        .post("updateMember", updateData)
        .then(res => {
          console.log(res.data);
          this.search();
          this.toModified ='';
          if (res.data.ret == 0) {
            alert("更新成功");
          }
        })
        .catch(ex => {});
        
    },

    //delete
    async deleteMember(member) {
      this.checkCSRFTOKEN();
      await axios
        .post("deleteMember", member)
        .then(res => {
          console.log(res.data);
          this.search();
          if (res.data.ret == 0) {
            alert("刪除成功");
          }
        })
        .catch(ex => {});
      this.isChange = "unchanged";
      
    },

    //create
    async newMember() {
      let MD5 = require("crypto-js/md5");
      let psdArray = MD5(this.memberData.psd);
      let psd = psdArray.words[0].toString()+psdArray.words[1].toString()+psdArray.words[2].toString()+psdArray.words[3].toString();
      let memberData = {
        acc: this.memberData.acc,
        psd: psd,
        name: this.memberData.name,
        phone: this.memberData.phone,
        email: this.memberData.email,
        status: this.memberData.status
      };
      this.checkCSRFTOKEN();
      await axios
        .post("newMember", memberData)
        .then(res => {
          if (res.data.ret == 0) {
            this.search();
          }
        })
        .catch(ex => {});
        
    },

    //search
    async search() {
      let searchDatas = {
        id: this.searchDatas.ID,
      }
      //this.checkCSRFTOKEN();
      await axios
        .post("search", searchDatas)
        .then(res => {
          console.log(res.data);
          if(res.data.ret == 1){
            console.log('Not Valid');
            this.memberList = null;
          }
          else{
            this.memberList = res.data.membersCollection;
            sessionStorage.setItem('memberList', JSON.stringify(this.memberList));
            this.show();
          }
        })
        .catch(ex => {});
        
    },

    //click tomodify
    toUpdate(member){
      this.toModified ='modified';
      sessionStorage.idToUpdate = member.id;
    },

    //show agent player or all
    show(){
      this.retrievedMemberList = JSON.parse(sessionStorage.getItem('memberList'));
      let i = 0;
      this.chosedMemberList = [];
      if(this.searchDatas.selected == 3){ //chosedMemberList放入 全部3 
        this.chosedMemberList = this.retrievedMemberList;
      }
      else{ //將chosedMemberList放入 代理0 或 玩家1
        this.retrievedMemberList.forEach(member => {
          if(member.Status == this.searchDatas.selected){
            this.chosedMemberList[i] = member;
            i=i+1;
          }
        });
      }
    },

    checkCSRFTOKEN(){
      var XSRFTOKEN = this.getCookie('XSRF-TOKEN');
      console.log(XSRFTOKEN);
      if(XSRFTOKEN == "")
      {
        window.location.reload();
      }
    },

    getCookie(cookieName) {
      var name = cookieName + "=";
      var decodedCookie = decodeURIComponent(document.cookie);
      var ca = decodedCookie.split(';');
      for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
      }
      return "";
    },

    test(){
      console.log(123);
    },
  },
  
  mounted() {
    this.search();

  }
};
</script>

<style>
tr th,
tr td {
  padding: 5px 20px;
}
</style>
