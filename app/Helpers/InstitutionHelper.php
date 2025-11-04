<?php

namespace App\Helpers;

use App\Services\InstitutionApiService;

class InstitutionHelper
{
    /**
     * Get list of universities/colleges (S1/D4)
     */
    public static function getUniversities(bool $useApi = false): array
    {
        // Static list
        return [
            // PTN (Perguruan Tinggi Negeri)
            'Universitas Indonesia (UI)',
            'Institut Teknologi Bandung (ITB)',
            'Universitas Gadjah Mada (UGM)',
            'Institut Pertanian Bogor (IPB)',
            'Universitas Padjadjaran (UNPAD)',
            'Universitas Airlangga (UNAIR)',
            'Institut Teknologi Sepuluh Nopember (ITS)',
            'Universitas Diponegoro (UNDIP)',
            'Universitas Brawijaya (UB)',
            'Universitas Hasanuddin (UNHAS)',
            'Universitas Sumatera Utara (USU)',
            'Universitas Andalas (UNAND)',
            'Universitas Sriwijaya (UNSRI)',
            'Universitas Lampung (UNILA)',
            'Universitas Jenderal Soedirman (UNSOED)',
            'Universitas Sebelas Maret (UNS)',
            'Universitas Jember (UNEJ)',
            'Universitas Mataram (UNRAM)',
            'Universitas Nusa Cendana (UNDANA)',
            'Universitas Cenderawasih (UNCEN)',
            'Universitas Sam Ratulangi (UNSRAT)',
            'Universitas Lambung Mangkurat (ULM)',
            'Universitas Mulawarman (UNMUL)',
            'Universitas Tanjungpura (UNTAN)',
            'Universitas Palangka Raya (UPR)',
            'Universitas Borneo Tarakan (UBT)',
            'Universitas Sultan Ageng Tirtayasa (UNTIRTA)',
            'Universitas Syiah Kuala (UNSYIAH)',
            'Universitas Riau (UNRI)',
            'Universitas Bengkulu (UNIB)',
            
            // PTS (Perguruan Tinggi Swasta) Populer
            'Universitas Bina Nusantara (BINUS)',
            'Universitas Trisakti',
            'Universitas Atma Jaya Yogyakarta',
            'Universitas Katolik Indonesia Atma Jaya',
            'Universitas Pelita Harapan (UPH)',
            'Universitas Kristen Indonesia (UKI)',
            'Universitas Tarumanagara',
            'Universitas Mercu Buana',
            'Universitas Gunadarma',
            'Universitas Telkom',
            'Universitas Multimedia Nusantara (UMN)',
            'Universitas Prasetiya Mulya',
            'Institut Teknologi Harapan Bangsa',
            'Universitas Esa Unggul',
            'Universitas Pancasila',
            
            // Politeknik
            'Politeknik Negeri Bandung (POLBAN)',
            'Politeknik Negeri Jakarta (PNJ)',
            'Politeknik Negeri Semarang (POLINES)',
            'Politeknik Negeri Medan (POLMED)',
            'Politeknik Negeri Makassar',
            
            // Akademi/STMIK/STIE
            'STMIK Amikom Yogyakarta',
            'STMIK Nusa Mandiri',
            'STIE YKPN Yogyakarta',
        ];
    }

    /**
     * Get list of high schools (SMA/SMK)
     */
    public static function getHighSchools(): array
    {
        return [
            // SMA Negeri Populer
            'SMA Negeri 1 Jakarta',
            'SMA Negeri 2 Jakarta',
            'SMA Negeri 3 Jakarta',
            'SMA Negeri 5 Jakarta',
            'SMA Negeri 8 Jakarta',
            'SMA Negeri 28 Jakarta',
            'SMA Negeri 1 Bandung',
            'SMA Negeri 3 Bandung',
            'SMA Negeri 5 Bandung',
            'SMA Negeri 1 Yogyakarta',
            'SMA Negeri 3 Yogyakarta',
            'SMA Negeri 1 Surabaya',
            'SMA Negeri 5 Surabaya',
            'SMA Negeri 1 Malang',
            'SMA Negeri 1 Semarang',
            'SMA Negeri 1 Medan',
            'SMA Negeri 2 Medan',
            'SMA Negeri 1 Makassar',
            'SMA Negeri 1 Denpasar',
            'SMA Negeri 1 Palembang',
            
            // SMA Swasta Populer
            'SMA Labschool Jakarta',
            'SMA Kanisius Jakarta',
            'SMA Santa Ursula Jakarta',
            'SMA Al Azhar Jakarta',
            'SMA Taruna Nusantara Magelang',
            'SMA Global Jaya',
            'SMA Ciputra Surabaya',
            
            // SMK Negeri
            'SMK Negeri 1 Jakarta',
            'SMK Negeri 2 Jakarta',
            'SMK Negeri 3 Jakarta',
            'SMK Negeri 4 Jakarta',
            'SMK Negeri 26 Jakarta',
            'SMK Negeri 57 Jakarta',
            'SMK Negeri 1 Bandung',
            'SMK Negeri 2 Bandung',
            'SMK Negeri 3 Bandung',
            'SMK Negeri 5 Bandung',
            'SMK Negeri 1 Yogyakarta',
            'SMK Negeri 2 Yogyakarta',
            'SMK Negeri 1 Surabaya',
            'SMK Negeri 2 Surabaya',
            'SMK Negeri 1 Malang',
            'SMK Negeri 1 Semarang',
            'SMK Negeri 1 Medan',
            'SMK Negeri 1 Makassar',
            'SMK Negeri 1 Denpasar',
            
            // SMK Swasta Populer
            'SMK Telkom Bandung',
            'SMK Telkom Jakarta',
            'SMK Telkom Malang',
            'SMK Bina Informatika',
            'SMK Al Ma\'mun',
            
            // Generic untuk input manual jika tidak ada di list
        ];
    }

    /**
     * Get all institutions sorted
     */
    public static function getAllInstitutions(): array
    {
        return array_merge(self::getUniversities(), self::getHighSchools());
    }

    /**
     * Get institutions by education level
     */
    public static function getByEducationLevel(?string $level): array
    {
        if ($level === 'S1/D4') {
            return self::getUniversities();
        } elseif ($level === 'SMA/SMK') {
            return self::getHighSchools();
        }
        
        return self::getAllInstitutions();
    }
}

