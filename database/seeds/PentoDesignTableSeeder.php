<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PentoDesignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userNumArray =
            [
                // 1 ~ 5단계
                1, 1, 1, 1, 1, 1, 1,
                1, 1, 1, 1, 1, 1, 1,
                1, 1, 1, 1, 1, 1, 1,
                1, 1, 1, 1, 1, 1, 1,
                1, 1, 1, 1, 1, 1, 1,
                // 모두의 펜토미노
                1, 1, 1,
                1, 2, 3, 72, 75, 30, 10, 20, 31, 68, 90, 88,
                1, 1

            ];
        $pointArray =
            [
                // 1단계
                500, 500, 500, 500, 500, 500, 500,
                // 2단계
                700, 700, 700, 700, 700, 700, 700,
                // 3단계
                900, 900, 900, 900, 900, 900, 900,
                // 4단계
                1100, 1100, 1100, 1100, 1100, 1100, 1100,
                // 5단계
                1300, 1300, 1300, 1300, 1300, 1300, 1300,
                // 모두의 펜토미노
                0, 0, 0,

                0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                0, 0
            ];
        $designTitleArray =
            [
                // 1단계
                'flag', 'cap', 'duck', 'puppy', 'tree', 'snail', 'earthworm',
                // 2단계
                'sparrow', 'deer', 'elephant', 'yacht', 'cat', 'television', 'I_of_the_alphabet',
                // 3단계
                'squirrel', 'helicopter', 'syringe', 'dog', 'pyramid', 'UFO', 'rhinoceros',
                // 4단계
                'crocodile', 'windmill', 'pigeon', 'top', 'lion', 'battery', 'cross',
                // 5단계
                'melon', 'castle', 'ostrich', 'glass', 'donkey', 'twin_building', 'bridge',
                // 모두의 펜토미노
                'flower', 'icecream', 'cake',

                'school', 'camel', 'face_of_robot', 'rooster', 'butterfly', 'bull', 'skyscraper', 'penguin', 'helicopter2', 'phoenix', 'giraffe', 'elephant2',
                'door_handle', 'witch'

            ];
        $coordinateValueArray =
            [
                // 1단계
                '000000000000000000000000000000000000000000000000000000000000000000000000000000001111000000000001111000000000001000000000000001000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '00000000000000000000000000000000000000000000000000000000000000000000000000000000011000000000000011000000000000011000000000001111000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000' ,
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000001100000000000001000000000001111000000000000111000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000001100000000000000111000000000000111000000000000101000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000010000000000000111000000000001111100000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000011000000000001011000000000001111100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000111000000000011111110000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                // 2단계
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000001100000000001111000000000000111000000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000001100000000000011000000000000001000000000000001111100000000000111000000000000101000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000111100000000001111100000000001011100000000000010100000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000010000000000000011000000000000011100000000000010000000000001111100000000000111000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000010100000000000011100000000000011100000000011111000000000000101000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001111100000000001111100000000001111100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000001111000000000001111000000000000110000000000000110000000000001111000000000001111000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                // 3단계
                '000000000000000000000000000000000000000000000000000000000000000000000100000000011001100000000011111000000000001110000000000001010000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000011100000000010001000000000011111100000000000111100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000010000000000000111000000000000111000000000000111000000000001111100000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000100000000000001100000000000001100100000000000111100000000000101100000000000101000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000011000000000000111100000000001111110000000011111111000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000010000000000000111000000000001111100000000011111110000000000111000000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000010111100000000011111110000000011111100000000000100100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                // 4단계
                '000000000000000000000000000000000000000000000000000000000000000000000000000000010000000000001111111110000000011111111000000001001000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000001000000000011111000000000001111000000000001111000000000001111100000000001000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000011000000000000001110000000000001111100000000001111110000000001110000000000000100000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000110000000000011111100000000011111100000000001111000000000000110000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000001000000000000011100000000000001111110000000000111100000000000111100000000000101000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000010000000000000111000000000000111000000000000111000000000000111000000000000111000000000000111000000000000111000000000000111000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000110000000000000110000000000011111100000000011111100000000000110000000000000110000000000000110000000000000110000000000000110000000000000000000000000000000000000000000000000000',

                // 5단계
                '000000000000000000000000000000000000000000000000000000000000000000111000000000000010000000000000111000000000001111100000000001111100000000001111100000000000111000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000010000000000000010000000000000111000000000000111000000000000111000000000010111010000000011111110000000011111110000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000111000000000000001001000000000001111100000000001111000000000001111000000000000010000000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000011111110000000001111100000000001111100000000000111000000000000010000000000000010000000000000111000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000001000000000000001110000000000001000000000011111000000000111111000000000011111000000000001001000000000001001000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000001000000000000001100000000000001110000000000001111000000000001111100000000001111100000000001111100000000001111100000000001111100000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000001111111111000001111111111000001111001111000000110000110000000110000110000000110000110000000000000000000000000000000000000000000000000000000000000000000000000000000',
                // 모두의 펜토미노 ㅇㅅㅇ
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000101000000000000111000000000000010000000000000111000000000000010000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000010000000000000111000000000001111100000000011111110000000001111100000000000111000000000000111000000000000111000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000111000000000000111000000000001111100000000001111100000000011111110000000011111110000000000000000000000000000000000000000000000000000000000000000000000000000000',

                '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000110000000000001111000000000001111000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000011010000000000001111100000000001111100000000000101000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000011111100000000111111110000000011111100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000100000000000001110000000000001100000000000111000000000010111000000000011111000000000001111000000000000011000000000000001000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000011000110000000011101110000000011111110000000001111100000000001111100000000011101110000000010000010000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000010111100000000011111110000000011111100000000001000100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000110000000000000110000000000000110000000000011111100000000011111100000000011111100000000011111100000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000111000000000000101110000000000111000000000000111100000000001111110000000011111110000000111111111000000101111101000000001111100000000001111100000000001111100000000000101000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000011111000000000000100000000000001111110000100001111111111100001111111000100000111000000000000010000000000001111000000000000000000000000000000000000000000000000000000000000000000000',
                '000001000000000000001100000000000001110000000000001111000000000000011000000001110011100100001110001100100000111111111100000111111111100000000111000100000000010000000000000110000000000001110000000000000111000000000000011000000',
                '000000000000000000000000000000000000000000000000110000000000000010000000000000011000000000000011000000000000011100000000000011110000000000010010000000000010010000000000010010000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000001100000000000011111110000000010111110000000010110110000000010010010000000000010010000000000000000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000000000000000000010000000000000111000000000001111100000000011111110000000001111100000000000111000000000000010000000000000000000000000000000000000000000000000000000000000000000',
                '000000000000000000000000000000000000000000000000000110000000000011111100000000001111000000000001111000000000000110000000000011111100000000001111000000000001001000000000000000000000000000000000000000000000000000000000000000000'
            ];

        $identifier =
            [
                '1', '1', '1', '1', '1', '1', '1',
                '2', '2', '2', '2', '2', '2', '2',
                '3', '3', '3', '3', '3', '3', '3',
                '4', '4', '4', '4', '4', '4', '4',
                '5', '5', '5', '5', '5', '5', '5',
                'every', 'every', 'every',
                'every', 'every', 'every', 'every', 'every', 'every', 'every', 'every', 'every', 'every', 'every', 'every',
                'every', 'every'
            ];

        $hourArray =
            [
                1, 2, 3, 4, 5, 1, 2, 3, 4, 5,
                1, 1, 1, 3, 4, 5, 1, 2, 8, 6,
                7, 3, 7, 8, 3, 9, 1, 2, 0, 2,
                3, 1, 2, 3, 5, 4, 4, 3, 2, 8,
                9, 2, 3, 4, 5, 3, 5, 3, 5, 8,
                7, 7
            ];
        // 분 배열 -> addMinutes 매개변수로 사용하기위해 현재 분에 값만큼 더한 값
        $minuteArray =
            [
                10, 12, 0, 12, 4, -32, 48, 32, -11, -10,
                20, 1, 2, 4, 5, 10, 13, 52, -48, -10,
                1, -2, -30, -40, -57, -10, -55, -1, -6, 30
                - 10, 1, 2, 3, 4, -40, -71, -20, 20, 40,
                11, 12, 13, 48, 32, -27, -26, 28, 30, 40, 20,
                0, 12

            ];



        for ($i = 0; $i < count($userNumArray); $i++) {
            DB::table('pento_designs')->insert
            (
                [
                    'user_no' => $userNumArray[$i],
                    'reward_point' => $pointArray[$i],
                    'design_title' => $designTitleArray[$i],
                    'design_explain' => $designTitleArray[$i] . "です！面白く解説してみましょう! ><~!",
                    'coordinate_value' => $coordinateValueArray[$i],
                    'design_image' => $designTitleArray[$i] . ".jpg",
                    'identifier' => $identifier[$i],
                    'registered_date' => Carbon::now()->addHour($hourArray[$i])->addMinute($minuteArray[$i])->format('Y-m-d H:i:s'),
                    'updated_date' => Carbon::now()->addHour($hourArray[$i])->addMinute($minuteArray[$i])->format('Y-m-d H:i:s')
                ]
            );
        }
    }
}