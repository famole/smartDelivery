<?php

namespace frontend\enum;

class EnumBaseStatus {
    const Pendiente = 'Pendiente';
    const PendArmar = 'Pendiente-Armar';
    const Entregado = 'Entregado';
    const PendienteReparto = 'Pendiente-Reparto';
    
    //**********Reparto****************
    const Preparado = 'Preparado';
    const EnCurso = 'En curso';
    const Finalizado = 'Finalizado';
    const Cancelado = 'Cancelado';
    //*********************************
    
}
