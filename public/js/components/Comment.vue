<template>
    <div id="app">
        <h2 class="text-center">Comentarios</h2>
        <div class="well">
            <h4>Escribe tu comentario</h4>
            <form v-on:submit.prevent="createComment">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" v-model="newComment" maxlength="256">

                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-sm">
                            Agregar
                        </button>
                    </span>
                </div>
            </form>
            <hr>
            <ul class="list-unstyled">
                <li style="border-top: 1px solid #cccccc; border-top: 1px solid #cccccc; margin-top: 20px" v-for="comment in comments">
                    <p>
                        <small class="text-muted"><em>{{ since(comment.created_at) }}</em></small>
                        <h5>{{ comment.description }} </h5>
                        <span class="pull-right" style="font-weight: bold">{{ comment.username }}</span>
                    </p>
                    <br>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import axios  from 'axios'
    import toastr from 'toastr'
    import moment from 'moment'

    moment.locale('es');

    export default {
            props:['anexo'],
            mounted() {
                  console.log(this.anexo)
            },
        data () {
            return {
                comments : [],
                username : [],
                newComment: '',
                anexoComment: '',
            }
        },
        created: function() {
            this.getComments();
        },
        methods: {
            since: function(d) {
                return moment(d).fromNow();
            },
            getComments: function(page) {
                var urlComentarios = '/mis-comentarios/' + this.anexo;
                axios.get(urlComentarios).then(response => {
                    this.comments = response.data
                });
            },
            createComment: function() {
                var url = '/guardar-comentario';
                axios.post(url, {
                    description: this.newComment,
                    anexo_id:    this.anexo
                }).then(response => {
                    this.getComments();
                    this.newComment = '';
                    toastr.success('Comentario registrado');
                }).catch(error => {
                    toastr.error('Error');
                });
            }
        }
    }
</script>
