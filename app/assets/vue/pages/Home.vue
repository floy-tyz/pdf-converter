<template>
    <div class="home-page">

        <h1> Converter </h1>

        <div class="form">

            <label class="center" v-show="!files.length">
                <span class="label-span select-button">Выберите файлы</span>
                <input type="file" @change="uploadFile($event)" multiple="multiple">
            </label>

            <div class="files-table center" v-show="files.length">

                <div class="files">
                    <div class="file row" v-for="file in files">
                        <label class="group">
                            <span class="label-span">Название файла:</span>
                            <input class="name-input w250" v-model="file.name">
                        </label>
                        <label class="group">
                            <span class="label-span">Конвертировать в:</span>
                            <select class="select-input" v-model="file.convert_type">
                                <option :value="type" v-for="type in convert_types">{{ type }}</option>
                            </select>
                        </label>
                    </div>
                </div>

                <button class="button select-button center" @click="send">Отправить</button>
            </div>

        </div>
    </div>
</template>

<script>

import axios from "axios";

export default {
    name: "Home",

    data() {
        return {
            files: [],
            convert_types: [
                'csv', 'xlsx'
            ]
        };
    },

    methods: {
        uploadFile(event) {

            let target = event.target;

            if (!target?.files || !target?.files.length === 0) {
                throw new Error('Файлы не выбраны');
            }

            this.files = target.files;
        },

        async send() {

            if (!this.files) {
                return alert('Ошибка валидации, проверьте заполненность полей')
            }

            let formData = new FormData();

            formData.append("files", this.files);

            console.log(this.files)

            let response = null;

            try {
                response = await axios.post('/api/upload', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
            } catch (e) {
                alert(e.message)
                return;
            }

            if (!response.data?.success) {
                alert(response.data?.message)
                return;
            }

            alert('Успешно');
            location.reload();
        }
    },
};
</script>

<style scoped>
    input[type="file"] {
        display: none;
    }
    .select-button {
        width: 200px;
        border-radius: 3px;
        height: 40px;
        background-color: #f33;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 2px 7px 10px 0 rgba(0,0,0,.1), 2px 11px 11px 0 rgba(0,0,0,.1), 2px 6px 8px 0 rgba(0,0,0,.08), 2px 5px 8px 0 rgba(252,22,0,.05);
        cursor: pointer;
    }
    .select-button:hover {
        background-color: #f33339;
    }

    .name-input {
        height: 16px;
        display: block;
        padding: 0.375rem 0.75rem;
        font-family: inherit;
        font-weight: 400;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #bdbdbd;
        border-radius: 0.25rem;
    }

    .select-input {
        width: 120px;
        height: 30px;
        padding: 0.375rem 0.75rem;
        font-family: inherit;
        font-weight: 400;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #bdbdbd;
        border-radius: 0.25rem;
    }

    .button {
        border: none;
        outline: none;
        margin-top: 10px;
    }

    .w250 {
        width: 250px;
    }
</style>