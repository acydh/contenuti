<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\Category;

class PermissionsTest extends TestCase
{
    use RefreshDatabase;
    protected $writer1;
    protected $writer2;
    protected $editor1;
    protected $editor2;
    protected $articleEditor1;
    protected $articleEditor2;
    protected $articleWriter1;
    protected $articleWriter2;

    public function setUp(): void {
        parent::setUp();

        /* Setup Roles */

        Role::create(['name' => 'Editor', 'guard_name' => 'api']);
        Role::create(['name' => 'Writer', 'guard_name' => 'api']);

        $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

        /* Setup Users */

        $this->writer1 = User::factory()->create();
        $this->writer1->assignRole(Role::findByName('Writer', 'api'));

        $this->writer2 = User::factory()->create();
        $this->writer2->assignRole(Role::findByName('Writer', 'api'));

        $this->editor1 = User::factory()->create();
        $this->editor1->assignRole(Role::findByName('Editor', 'api'));

        $this->editor2 = User::factory()->create();
        $this->editor2->assignRole(Role::findByName('Editor', 'api'));

        /* Setup Categories */
        Category::factory()->create();

        /* Setup Articles */

        $this->articleEditor1 = Article::factory()->create(
            [
                'title'     => 'Published article from editor1',
                'author_id' => $this->editor1->id,
                'status'    => 1,
            ]
        );

        $this->articleEditor2 = Article::factory()->create(
            [
                'title'     => 'Unpublished article from editor2',
                'author_id' => $this->editor2->id,
                'status'    => 0,
            ]
        );

        $this->articleWriter1 = Article::factory()->create(
            [
                'title'     => 'Published article from writer1',
                'author_id' => $this->writer1->id,
                'status'    => 1,
            ]
        );

        $this->articleWriter2 = Article::factory()->create(
            [
                'title'     => 'Unpublished article from writer2',
                'author_id' => $this->writer2->id,
                'status'    => 0,
            ]
        );
    }

    /**
     * @test
     */
    public function guestsCanViewArticleGuestIndex() {
        $response = $this->json('GET', 'api/guest/articles');

        $response->assertStatus(200)->assertJson(
            [
                'data' => [],
            ]
        );
    }

    /**
     * @test
     */
    public function guestsCannotViewArticleIndex() {
        $response = $this->json('GET', 'api/articles');

        $response->assertStatus(401)->assertExactJson(
            ['message' => 'Unauthenticated.']
        );
    }

    /**
     * @test
     */
    public function writersAndEditorsCanViewPostsIndex() {
        $response = $this->actingAs($this->writer1)->json('GET', 'api/articles');

        $response->assertStatus(200)->assertJson(
            [
                'data' => [],
            ]
        );
    }

    /**
     * @test
     */
    public function writersCannotPublishOrUnpublishArticles() {
        // Publish
        $this->assertEquals($this->articleWriter2->fresh()->status, 0);
        $response = $this->actingAs($this->writer1)->json('PATCH', "api/articles/{$this->articleWriter1->id}", ['status' => 1]);
        $response->assertStatus(403);
        $this->assertEquals($this->articleWriter2->fresh()->status, 0);

        // Unpublish
        $this->assertEquals($this->articleWriter1->fresh()->status, 1);
        $response = $this->actingAs($this->writer1)->json('PATCH', "api/articles/{$this->articleWriter1->id}", ['status' => 0]);
        $response->assertStatus(403);
        $this->assertEquals($this->articleWriter1->fresh()->status, 1);
    }

    /**
     * @test
     */
    public function writersCanEditTheirUnpublishedArticles() {
        $this->assertEquals($this->articleWriter2->fresh()->status, 0);
        $response = $this->actingAs($this->writer2)->json('PATCH', "api/articles/{$this->articleWriter2->id}", ['title' => 'Modified title']);
        $response->assertStatus(200);
        $this->assertEquals($this->articleWriter2->fresh()->title, 'Modified title');
    }

    /**
     * @test
     */
    public function writersCannotEditTheirPublishedArticles() {
        $this->assertEquals($this->articleWriter1->fresh()->status, 1);
        $previousTitle = $this->articleWriter1->fresh()->title;
        $response      = $this->actingAs($this->writer1)->json('PATCH', "api/articles/{$this->articleWriter1->id}", ['title' => 'Modified title']);
        $response->assertStatus(403);
        $this->assertEquals($this->articleWriter1->fresh()->title, $previousTitle);
    }

    /**
     * @test
     */
    public function editorsCanPublishOrUnpublishWritersArticles() {
        // Publish
        $this->assertEquals($this->articleWriter2->fresh()->status, 0);
        $response = $this->actingAs($this->editor1)->json('PATCH', "api/articles/{$this->articleWriter2->id}", ['status' => 1]);
        $response->assertStatus(200);
        $this->assertEquals($this->articleWriter2->fresh()->status, 1);

        // Unpublish
        $this->assertEquals($this->articleWriter1->fresh()->status, 1);
        $response = $this->actingAs($this->editor1)->json('PATCH', "api/articles/{$this->articleWriter1->id}", ['status' => 0]);
        $response->assertStatus(200);
        $this->assertEquals($this->articleWriter1->fresh()->status, 0);
    }

    /**
     * @test
     */
    public function editorsCannotPublishOrUnpublishOtherEditorsArticles() {
        // Publish
        $this->assertEquals($this->articleEditor2->fresh()->status, 0);
        $response = $this->actingAs($this->editor1)->json('PATCH', "api/articles/{$this->articleEditor2->id}", ['status' => 1]);
        $response->assertStatus(403);
        $this->assertEquals($this->articleEditor2->fresh()->status, 0);

        // Unpublish
        $this->assertEquals($this->articleEditor1->fresh()->status, 1);
        $response = $this->actingAs($this->editor2)->json('PATCH', "api/articles/{$this->articleEditor1->id}", ['status' => 0]);
        $response->assertStatus(403);
        $this->assertEquals($this->articleEditor1->fresh()->status, 1);
    }

    /**
     * @test
     */
    public function editorsCanPublishOrUnpublishTheirOwnArticles() {
        // Publish
        $this->assertEquals($this->articleEditor2->fresh()->status, 0);
        $response = $this->actingAs($this->editor2)->json('PATCH', "api/articles/{$this->articleEditor2->id}", ['status' => 1]);
        $response->assertStatus(200);
        $this->assertEquals($this->articleEditor2->fresh()->status, 1);

        // Unpublish
        $this->assertEquals($this->articleEditor1->fresh()->status, 1);
        $response = $this->actingAs($this->editor1)->json('PATCH', "api/articles/{$this->articleEditor1->id}", ['status' => 0]);
        $response->assertStatus(200);
        $this->assertEquals($this->articleEditor1->fresh()->status, 0);
    }
}
