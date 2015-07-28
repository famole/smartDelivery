<?php

namespace frontend\enum;

class EnumProcessError {
    const noDir = 'No fue posible resolver la direccion.';
    const manyDir = 'Existen varios resultados para la direccion.';
    const dirEmpty = 'Direccion vacia.';
    const dateEmpty = 'Fecha vacia.'; //no crea entrega
    const cliEmpty = 'Cliente vacio.'; //no crea entrega
}
