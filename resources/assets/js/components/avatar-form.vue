<template>
    <div>
        <div class="level">
            <img :src="avatar" width="50" height="50" class="mr-1">

            <h1 v-text="user.name"></h1>
        </div>

        <form v-if="canUpdate" method="POST" enctype="multipart/form-data">
            <image-upload name="avatar" class="mr-1" @loaded="onLoad"></image-upload>
        </form>

    </div>
</template>
