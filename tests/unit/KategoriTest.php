<?php

use App\Database\Seeds\KategoriSeeder;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Test\CIUnitTestCase;

use CodeIgniter\Test\DatabaseTestTrait;
use CodeIgniter\Test\FeatureTestTrait;

class KategoriTest extends CIUnitTestCase
{
    use DatabaseTestTrait;
    use FeatureTestTrait;

    // For Migrations
    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $namespace   = ['App','Tests\Support'];

    // For Seeds
    protected $seed     = KategoriSeeder::class;

    protected $jwt = null;

    protected function setUp(): void
    {
        parent::setUp();

        $users = auth()->getProvider();

        $user = new User([
            'username' => 'admin',
            'email'    => 'admin@gmail.com',
            'password' => 'katasandi',
        ]);
        $users->save($user);
        $user = $users->findById($users->getInsertID());
        $user->addGroup('admin');

        /** @var JWTManager $manager */
        $manager = service('jwtmanager');

        $claims = [
            'role' => $user->getGroups()[0],
        ];

        // Generate JWT
        $this->jwt = $manager->generateToken($user, $claims);
    }

    public function testKategoriIndex()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('get', 'kategori');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsArray($array_data);

        $this->assertEquals($array_data[0]->id, '1');
        $this->assertEquals($array_data[0]->id_event, '1');
    }

    public function testKategoriInsert()
    {
        $data = [
            'id_event' => '2',
            'kategori' => 'Komputer',
            'pendaftaran' => '2021-01-02',
            'jam_awal_pendaftaran' => '2021-01-02 00:00:00',
            'jam_akhir_pendaftaran' => '2021-01-02 00:00:00',
            'penyisihan' => '2021-01-02',
            'jam_awal_penyisihan' =>  '2021-01-02 00:00:00',
            'jam_akhir_penyisihan' => '2021-01-02 00:00:00',
            'pengumuman' => '2021-01-02',
            'final' => '2021-01-02',
        ];

        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->withBody(
            json_encode($data),
            'application/json'
        )
        ->call('post', 'kategori');

        $this->assertTrue($result->isOK());
        $result->assertStatus(201);
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        $this->assertEquals($array_data->id_event, '2');
        $this->assertEquals($array_data->kategori, 'Komputer');

        $this->seeInDatabase('kategori', ['id_event' => '2', 'kategori' => 'Komputer']);
    }

    public function testKategoriInsertFail()
    {
        $data = [
            'nama' => 'Event 1',
            'kategori' => 'Komputer',
        ];

        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->withBody(
            json_encode($data),
            'application/json'
        )->call('post', 'kategori');

        $result->assertStatus(400);
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        // Check message
        $this->assertEquals($array_data->id_event, 'ID event harus diisi.');
    }

    public function testKategoriUpdate()
    {
        $data = [
            'kategori' => 'Game'
        ];

        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->withBody(
                json_encode($data),
                'application/json'
            )
        ->call('put', 'kategori/1');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        $this->assertEquals($array_data->id_event, '1');
        $this->assertEquals($array_data->kategori, 'Game');
    }

    public function testKategoriUpdateFail()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('put', 'kategori/1');

        $result->assertStatus(400);
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        // Check message
        $this->assertEquals($array_data->message, 'Data Tidak Valid');
    }

    public function testKategoriDelete()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('delete', 'kategori/2');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        // Check message
        $this->assertEquals($array_data->message, 'Data berhasil dihapus');

        // Check if data is inserted to databases
        $this->dontSeeInDatabase('kategori', ['id' => '2']);
    }

    public function testKategoriDeleteFail()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('delete', 'kategori/100');

        $result->assertStatus(404);
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        // Check message
        $this->assertEquals($array_data->message, 'Data tidak ditemukan');
    }

    public function testKategoriFind()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('get', 'kategori/1');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        $this->assertEquals($array_data->id_event, '1');
        $this->assertEquals($array_data->kategori, 'Web Design');
    }

    public function testKategoriFindFail()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('get', 'kategori/100');

        $result->assertStatus(404);
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        // Check message
        $this->assertEquals($array_data->message, 'Data tidak ditemukan');
    }

    public function testKategoriSearch()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('get', 'kategori/search?kategori=Web Design');

        $this->assertTrue($result->isOK());
        
        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsArray($array_data);

        $this->assertEquals($array_data[0]->id_event, '1');
        $this->assertEquals($array_data[0]->kategori, 'Web Design');  
    }

    public function testKategoriSearchFail()
    {
        $result = $this
        ->withHeaders(['Authorization' => 'Bearer ' . $this->jwt])
        ->call('get', 'kategori/search');

        $result->assertStatus(400);

        $data = $result->response()->getJSON();
        $array_data = json_decode($data);
        $this->assertIsObject($array_data);

        // Check message
        $this->assertEquals($array_data->message, 'Query tidak sesuai');
    }
}