<?php
namespace bheller\ImagesGenerator;

class ImagesGeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->faker = \Faker\Factory::create();
        $this->faker->addProvider(new ImagesGeneratorProvider($this->faker));
        
        $this->files = null;
    }
    
    /**
     * Clean up any temporary images
     */
    public function tearDown()
    {
        if ($this->files !== null) {
            foreach ($this->files as $f) {
                @unlink($f);
            }
        }
    }
    
    private function _testImage($test)
    {
        $this->assertNotNull(@exif_imagetype($test));
    }
    
    /**
     * Test creating an image with the default setup
     *
     * @return void
     */
    public function testCreateDefaultImage()
    {
        $this->files[] = $test = $this->faker->imageGenerator();
        $this->_testImage($test);
    }
    
    /**
     * Test using a invalid directory, /dev/null
     *
     * @return void
     */
    public function testInvalidDirectory()
    {
        try {
            $this->faker->imageGenerator('/dev/null');
        } catch (\Exception $e) {
            $this->assertEquals($e->getMessage(), 'Cannot write to directory "/dev/null"');
        }
    }
    
    /**
     * Test using text using a colour without a hex
     *
     * @return void
     */
    public function testTextColorHex()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'png', true, null, '#0000ff');
        $this->_testImage($test);
    }
    
    /**
     * Test using text using a colour with a hex
     *
     * @return void
     */
    public function testTextColorHexNoHash()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'png', true, null, '0000ff');
        $this->_testImage($test);
    }
    
    /**
     * Test using a background colour with a hex
     *
     * @return void
     */
    public function testBackgroundColorHex()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'png', true, 'ImagesGenerator', null, '#0000ff');
        $this->_testImage($test);
    }
    
    /**
     * Test using a background colour without a hex
     *
     * @return void
     */
    public function testBackgroundColorHexNoHash()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'png', true, 'ImagesGenerator', null, '0000ff');
        $this->_testImage($test);
    }
    
    /**
     * Test showing text over the image
     *
     * @return void
     */
    public function testText()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'png', true, 'ImagesGenerator');
        $this->_testImage($test);
    }
    
    /**
     * Test using the width and height as the text
     *
     * @return void
     */
    public function testTextWidthHeight()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'png', true, true);
        $this->_testImage($test);
    }
    
    /**
     * Test creating a image with an extention of .jpg
     *
     * @return void
     */
    public function testJPG()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'jpg');
        $this->_testImage($test);
    }
    
    /**
     * Test creating a image with an extention of .jpeg
     *
     * @return void
     */
    public function testJPEG()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'jpeg');
        $this->_testImage($test);
    }
    
    /**
     * Test creating a image with an extention of .png
     *
     * @return void
     */
    public function testPNG()
    {
        $this->files[] = $test = $this->faker->imageGenerator(null, 640, 480, 'png');
        $this->_testImage($test);
    }
}
