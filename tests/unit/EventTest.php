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
    protected $seedOnce = false;
    protected $seed     = 'EventSeeder';
    protected $basePath = 'App\Database';

    public function testEventIndex()
    {
        $result = $this->call('get', 'event');

        $this->assertTrue($result->isOK());
        
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

    public function testEventInsert()
    {
        $data = [
            'nama' => 'Event 5',
            'keterangan' => 'Keterangan event 5',
            'tanggal' => '2021-01-05',
            'tempat' => 'Tempat event 5',
            'penanggung_jawab' => 'Penanggung jawab event 5',
            'gambar_poster' => 'event-5-poster.jpg',
            'gambar_banner' => 'event-5-banner.jpg'
        ];

        $result = $this->withBody(
            json_encode($data),
            'application/json'
        )->call('post', 'event');

        $this->assertTrue($result->isOK());
        $result->assertStatus(201);
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        $this->assertEquals($array_data->nama, 'Event 5');
        $this->assertEquals($array_data->keterangan, 'Keterangan event 5');
        $this->assertEquals($array_data->tanggal, '2021-01-05');
        $this->assertEquals($array_data->tempat, 'Tempat event 5');
        $this->assertEquals($array_data->penanggung_jawab, 'Penanggung jawab event 5');
        $this->assertEquals($array_data->gambar_poster, 'event-5-poster.jpg');
        $this->assertEquals($array_data->gambar_banner, 'event-5-banner.jpg');

        // Check if data is inserted to database
        $this->seeInDatabase('event', ['nama' => 'Event 3']);
    }

    public function testEventUpdate()
    {
        $data = [
            'nama' => 'Event 2 Baru',
            'keterangan' => 'Keterangan event 2',
            'tanggal' => '2021-01-02',
            'tempat' => 'Tempat event 2',
            'penanggung_jawab' => 'Penanggung jawab event 2',
            'gambar_poster' => 'event-2-poster.jpg',
            'gambar_banner' => 'event-2-banner.jpg'
        ];

        $result = $this->
            withBody(
                json_encode($data),
                'application/json'
            )->call('put', 'event/1');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        $this->assertEquals($array_data->nama, 'Event 2 Baru');
        $this->assertEquals($array_data->keterangan, 'Keterangan event 2');
        $this->assertEquals($array_data->tanggal, '2021-01-02');
        $this->assertEquals($array_data->tempat, 'Tempat event 2');
        $this->assertEquals($array_data->penanggung_jawab, 'Penanggung jawab event 2');
        $this->assertEquals($array_data->gambar_poster, 'event-2-poster.jpg');
        $this->assertEquals($array_data->gambar_banner, 'event-2-banner.jpg');
    }

    public function testEventDelete()
    {
        $result = $this->call('delete', 'event/2');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        // Check message
        $this->assertEquals($array_data->message, 'Data berhasil dihapus');

        // Check if data is inserted to databases
        $this->dontSeeInDatabase('event', ['nama' => 'Event 2 Baru']);
    }

    public function testEventFind()
    {
        $result = $this->call('get', 'event/1');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        $this->assertEquals($array_data->nama, 'Event 1');
        $this->assertEquals($array_data->keterangan, 'Keterangan event 1');
        $this->assertEquals($array_data->tanggal, '2021-01-01');
        $this->assertEquals($array_data->tempat, 'Tempat event 1');
        $this->assertEquals($array_data->penanggung_jawab, 'Penanggung jawab event 1');
        $this->assertEquals($array_data->gambar_poster, 'event-1-poster.jpg');
        $this->assertEquals($array_data->gambar_banner, 'event-1-banner.jpg');   
    }
}