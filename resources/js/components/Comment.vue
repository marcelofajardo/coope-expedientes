<template>
    <div id="app">
        <h2 class="text-center">Comentarios</h2>
        <div class="well">
            <h4>¿En que estás pensando?</h4>
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
                <li v-for="idea in ideas">
                    <p>
                        <small class="text-muted"><em>{{ since(coment.created_at) }}</em></small>
                        {{ comment.description }}
                    </p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import axios  from 'axios'
    import toastr from 'toastr'
    import moment from 'moment'

    moment.lang('es');

    export default {
        data () {
            return {
                ideas : [],
                newComment: '',
            }
        },
        created: function() {
            this.getComments();
        },
        methods: {
            since: function(d) {
                return moment(d).fromNow();
            },
            getComment: function(page) {
                var urlIdeas = 'mis-ideas';
                axios.get(urlIdeas).then(response => {
                    this.ideas = response.data
                });
            },
            createComment: function() {
                var url = 'guardar-idea';
                axios.post(url, {
                    description: this.newComment
                }).then(response => {
                    this.getComments();
                    this.newComment = '';
                    toastr.success('Nueva idea registrada');
                }).catch(error => {
                    toastr.error('Error');
                });
            }
        }
    }
</script>
