<?php

use CodeIgniter\Test\CIUnitTestCase;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

use function PHPSTORM_META\type;

class EventTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = ['App','Tests\Support'];

    // For Seeds
    protected $seedOnce = true;
    protected $seed     = 'EventSeeder';
    protected $basePath = 'App\Database';

    public function testEventIndex()
    {
        $result = $this->call('get', 'event');

        $this->assertTrue($result->isOK());
        $result->assertJSONCount(4);
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsArray($array_data);

        $this->assertEquals($array_data[0]->nama, 'Event 1');
        $this->assertEquals($array_data[0]->keterangan, 'Keterangan event 1');
        $this->assertEquals($array_data[0]->tanggal, '2021-01-01');
        $this->assertEquals($array_data[0]->tempat, 'Tempat event 1');
        $this->assertEquals($array_data[0]->penanggung_jawab, 'Penanggung jawab event 1');
        $this->assertEquals($array_data[0]->gambar_poster, 'event-1-poster.jpg');
        $this->assertEquals($array_data[0]->gambar_banner, 'event-1-banner.jpg');
    }
}