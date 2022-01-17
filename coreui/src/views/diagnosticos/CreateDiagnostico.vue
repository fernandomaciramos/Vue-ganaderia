<template>
  <CRow>
    <CCol col="12" lg="6">
      <CCard no-header>
        <CCardBody>
          <CForm>
            <h3>
              Diagnosticar al animal de id:  {{ $route.params.id }}
            </h3>
            <CAlert
              :show.sync="dismissCountDown"
              color="primary"
              fade
            >
              ({{dismissCountDown}}) {{ message }}
            </CAlert>
            <CTextarea type="text" label="Diagnostico" placeholder="Escribe el Diagnostico" v-model="diagnostico.diagnostico" valid-feedback="Thank you :)"
                invalid-feedback="Campo vacío no válido"
                :is-valid="validatorvacio"></CTextarea>
            <CTextarea type="text" label="Tratamiento" placeholder="Escribe el Tratamiento" v-model="diagnostico.tratamiento" valid-feedback="Thank you :)"
                invalid-feedback="Campo vacío no válido"
                :is-valid="validatorvacio"></CTextarea>
            <CInput
                label="Inicio del Tratamiento"
                type="date"
                horizontal
                v-model="diagnostico.inicio"
                valid-feedback="Thank you :)"
                invalid-feedback="Campo vacío no válido"
                :is-valid="validatorfechainicio"
              />
              <CInput
                label="Final del Tratamiento"
                type="date"
                horizontal
                v-model="diagnostico.final"
                valid-feedback="Thank you :)"
                invalid-feedback="Campo vacío no válido"
                :is-valid="validatorfechafinal"
              />
            <CInput type="bigint" label="Ganado Id" placeholder="Ganado" v-model="diagnostico.ganado_id" readonly></CInput>
            <CButton color="primary" @click="store()">Save</CButton>
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
            ganado_id:'',
        },
        message: '',
        dismissSecs: 7,
        dismissCountDown: 0,
    }
  },
  methods: {
    validatorvacio (val){
      return val ? val.length >= 1: false
    },
    validatorfechainicio (val){
      var hoy = new Date();
      // var fecha = hoy.getDate() + '-' + ( hoy.getMonth() + 1 ) + '-' + hoy.getFullYear();
      var fecha = hoy.getFullYear() + '-' + ( hoy.getMonth() + 1 ) + '-' + ("0" + hoy.getDate()).slice(-2);
      console.log(fecha);
      console.log(val);
     if(fecha.valueOf() > val.valueOf())
        return false
      else 
        return true
    },
    // validatorfechafinal (val){
    //   var inicio = dia.inicio;  
    //   console.log(fecha);
    //   console.log(val);
    //  if(inicio.valueOf() > val.valueOf())
    //     return false
    //   else 
    //     return true
    // },
    goBack() {
      this.$router.go(-1)
      // this.$router.replace({path: '/users'})
    },
    // update() {
    //     let self = this;
    //     console.log("estoy en update");
    //     axios.post(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '?token=' + localStorage.getItem("api_token"),
    //     {
    //         _method: 'PUT',
    //         name: self.ganado.name,
    //         crotal: self.ganado.crotal,
    //         ganaderia_id: self.ganado.ganaderia_id,
    //     })
    //     .then(function (response) {
    //         console.log("estoy en funcion");
    //         console.log(self.ganado.ganaderia.id),
    //         self.message = 'Successfully updated user.';
    //         self.showAlert();
    //     }).catch(function (error) {
    //         console.log(error);
    //         // self.$router.push({ path: '/login' });
    //     });
    // },
    store() {
        let self = this;
        console.log(self);
        axios.post(  this.$apiAdress + '/api/diagnosticos?token=' + localStorage.getItem("api_token"),
          {
            diagnostico: self.diagnostico.diagnostico,
            tratamiento: self.diagnostico.tratamiento,
            inicio: self.diagnostico.inicio,
            final: self.diagnostico.final,
            ganado_id:self.diagnostico.ganado_id,
          }
        )
        .then(function (response) {
            self.note = {
              title: '',
              content: '',
              applies_to_date: '',
              status_id: null,
              note_type: '',
            };
            self.message = 'Diagnostico Creado con exito.';
            self.showAlert();
        }).catch(function (error) {
            console.log('estoy catch del create');
            if(error.response.data.message == 'The given data was invalid.'){
              self.message = '';
              for (let key in error.response.data.errors) {
                if (error.response.data.errors.hasOwnProperty(key)) {
                  self.message += error.response.data.errors[key][0] + '  ';
                }
              }
              self.showAlert();
            }else{
              console.log(error);
              console.log('estoy en el else del catch');
              self.$router.push({ path: 'login' }); 
            }
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
    axios.get(  this.$apiAdress + '/api/ganados/' + self.$route.params.id + '/edit?token=' + localStorage.getItem("api_token"))
    .then(function (response) {
        self.diagnostico.ganado_id = response.data.id;
        console.log(self.ganado);
        // self.email = response.data.email; 
        // console.log(self.name);
    }).catch(function (error) {
        console.log(error);
        // self.$router.push({ path: '/login' });
    });
  }
}


</script>
