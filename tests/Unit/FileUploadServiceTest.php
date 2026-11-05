<?php

namespace Tests\Unit;

use App\Services\FileUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadServiceTest extends TestCase
{
    public function test_can_upload_and_delete_file(): void
    {
        Storage::fake('public');

        $service = new FileUploadService;
        $file = UploadedFile::fake()->image('test.jpg');

        $path = $service->upload($file, 'test-uploads');

        Storage::disk('public')->assertExists($path);

        $deleted = $service->delete($path);
        $this->assertTrue($deleted);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_can_delete_embedded_content_images(): void
    {
        Storage::fake('public');

        $service = new FileUploadService;
        $file = UploadedFile::fake()->image('content.jpg');
        $path = $service->upload($file, 'news/content');

        Storage::disk('public')->assertExists($path);

        $html = '<p>Berikut ini berita kami:</p><img src="'.asset('storage/'.$path).'" /><p>Selesai</p>';
        $service->deleteEmbeddedContentImages($html);

        Storage::disk('public')->assertMissing($path);
    }

    public function test_can_process_and_extract_embedded_base64_images(): void
    {
        Storage::fake('public');

        $service = new FileUploadService;
        $base64Sample = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==';
        $html = '<p>Paragraf awal</p><img src="data:image/png;base64,'.$base64Sample.'" alt="Testing" /><p>Paragraf akhir</p>';

        $processedHtml = $service->processEmbeddedContentImages($html, 'news/content');

        $this->assertStringNotContainsString('data:image/png;base64', $processedHtml);
        $this->assertStringContainsString('storage/news/content/', $processedHtml);

        preg_match('/src="[^"]*\/storage\/([a-zA-Z0-9_\-\/]+\.[a-zA-Z0-9]+)"/i', $processedHtml, $matches);
        $this->assertNotEmpty($matches[1]);
        Storage::disk('public')->assertExists($matches[1]);
    }
}
