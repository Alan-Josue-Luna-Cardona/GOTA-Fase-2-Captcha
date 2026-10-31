<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

/**
 * Seeder temporal para poder probar el módulo de Lecturas localmente,
 * mientras los módulos reales de Clientes/Contadores/Tarifas/Tipos_Servicio
 * no tengan su propio CRUD terminado.
 *
 * Uso: php spark db:seed LecturasPruebaSeeder
 */
class LecturasPruebaSeeder extends Seeder
{
    public function run()
    {
        // --- 1. Tipo de servicio ---
        $tipoServicio = $this->db->table('Tipos_Servicio')
            ->getWhere(['nombre' => 'Residencial'])
            ->getRow(); // sin argumentos: fila 0 completa, como objeto

        if (! $tipoServicio) {
            $this->db->table('Tipos_Servicio')->insert([
                'nombre'      => 'Residencial',
                'descripcion' => 'Servicio residencial estándar (seed de prueba)',
                'activo'      => 1,
            ]);
            $tipoServicioId = $this->db->insertID();
        } else {
            $tipoServicioId = $tipoServicio->id;
        }

        // --- 2. Cliente de prueba ---
        $cliente = $this->db->table('Clientes')
            ->getWhere(['email' => 'cliente.prueba@gota.test'])
            ->getRow();

        if (! $cliente) {
            $this->db->table('Clientes')->insert([
                'nombre'    => 'Cliente de Prueba',
                'telefono'  => '00000000',
                'direccion' => 'Dirección de prueba, Zona 1',
                'email'     => 'cliente.prueba@gota.test',
                'activo'    => 1,
            ]);
            $clienteId = $this->db->insertID();
        } else {
            $clienteId = $cliente->id;
        }

        // --- 3. Contador de prueba ---
        $contador = $this->db->table('Contadores')
            ->getWhere(['codigo' => 'CONT-PRUEBA-001'])
            ->getRow();

        if (! $contador) {
            $this->db->table('Contadores')->insert([
                'cliente_id'       => $clienteId,
                'codigo'           => 'CONT-PRUEBA-001',
                'referencia'       => 'Contador de prueba',
                'sector'           => 'Sector 1',
                'tipo_servicio_id' => $tipoServicioId,
                'activo'           => 1,
            ]);
            $contadorId = $this->db->insertID();
        } else {
            $contadorId = $contador->id;
        }

        // --- 4. Tarifa vigente desde hoy, sin fecha de fin ---
        $tarifaExistente = $this->db->table('Tarifas')
            ->where('tipo_servicio_id', $tipoServicioId)
            ->where('activo', 1)
            ->countAllResults();

        if ($tarifaExistente === 0) {
            $this->db->table('Tarifas')->insert([
                'tipo_servicio_id'    => $tipoServicioId,
                'volumen_incluido_m3' => 10.00,
                'tarifa_base'         => 5.0000,
                'tarifa_exceso'       => 8.0000,
                'vigente_desde'       => date('Y-m-d'),
                'vigente_hasta'       => null,
                'activo'              => 1,
            ]);
        }

        echo "Seed de prueba listo. Contador #{$contadorId} disponible en /lecturas/nueva/{$contadorId}\n";
    }
}