<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <h3>
              Editar Diagnostico de id:  {{ $route.params.id }}
            </h3>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CTextarea type="text" label="Diagnostico" placeholder="Diagnostico" v-model="diagnostico.diagnostico"></CTextarea>
            <CTextarea type="text" label="Tratamiento" placeholder="Tratamiento" v-model="diagnostico.tratamiento"></CTextarea>
            <CInput type="date" label="Fecha inicio" placeholder="Fecha inicio" v-model="diagnostico.inicio"></CInput>
            <CInput type="date" label="Fecha final" placeholder="Fecha final" v-model="diagnostico.final"></CInput>
            <!-- <CInput type="text" label="Id Ganado" placeholder="Tratamiento" v-model="diagnostico.tratamiento"></CInput> -->
            <CButton color="primary" @click="update()">Save</CButton>
            <CButton color="primary" @click="goBack">Back</CButton>
          </CForm>
        </CCardBody>
      </CCard>
    </CCol>
  </CRow>
    

</template>

<script>
import axios from 'axios'
export default {
  name: 'EditUser',
  props: {
    caption: {
      type: String,
      default: 'User id'
    },
  },
  data: () => {
    return {
       diagnostico:{   
            id: null,
            diagnostico: '',
            tratamiento: '',
            inicio:'',
            final:'',
            // ganado_id:'',
        },
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
    }
  },
  methods: {
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    update() {
        let self = this;
        console.log("estoy en update");
        axios.post(  this.$apiAdress + '/api/diagnosticos/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
        {
            _method: 'PUT',
            diagnostico: self.diagnostico.diagnostico,
            tratamiento: self.diagnostico.tratamiento,
            inicio: self.diagnostico.inicio,
            final: self.diagnostico.final,
            // ganado_id: self.ganado_id,
        })
        .then(function (response) {
            console.log("estoy en funcion");
            
            self.message = 'Actualización correcta del diagnostico.';
            self.showAlert();
        }).catch(function (error) {
            console.log(error);
            // self.$router.push({ path: '/login' });
        });
    },
    countDownChanged (dismissCountDown) {
      this.dismissCountDown = dismissCountDown
    },
    showAlert () {
      this.dismissCountDown = this.dismissSecs
    },
  },
  mounted: function(){
    let self = this;
    axios.get(  this.$apiAdress + '/api/diagnosticos/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.diagnostico = response.data;
        console.log(self.diagnostico);
        // self.email = response.data.email; 
        // console.log(self.name);
    }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
    });
  }
}


</script>
