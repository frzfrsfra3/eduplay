<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Question::class, function (Faker $faker) {
    return [

        'details' => 'Q:'.'What does the following mean? '.$faker->text(20),
        'questiontype'=>'text',
        'skill_id' => random_int(1, 50),
        'skillcategory_id' => null,
        'maxtime' => random_int(5, 300),
        'json_details' => json_encode([
            'ItemType' => 'Independant Question',
            'Attributes' => NULL,
            'Parameters' => 
                [                
                    [
                    'parameter' => 'f',
                    'value' => 
                    [
                    'type' => 'file',
                    'filename' => NULL,
                    ],
                    ],
                ],
            'Questions' => 
            [
            
              [
                'ItemType' => 'Question',
                'Attributes' => 
                [
                  'Difficulty' => 'easy',
                  'MinTime' => '0',
                  'MaxTime' => '60',
                  'Tag' => 'gk',
                  'Type' => 'multichoice',
                ],
                'Question_Description' => 
                [
                  'Attributes' => NULL,
                  'Sections' => 
                    [
                        [
                        'SectionType' => 'text',
                        'Attributes' => NULL,
                        'Value' => $faker->text(20),
                        ],
                    ],
                ],
                'Answers' => 
                [
                  'Attributes' => NULL,
                  'Choices' => 
                  [
                  
                        [
                        'Attributes' => 
                            [
                            'IsCorrect' => false,
                            ],
                        'Sections' => 
                        [
                            [
                            'SectionType' => 'text',
                            'Attributes' => NULL,
                            'Value' => $faker->text(10),
                            ],
                        ],
                    ],
                    
                    [
                      'Attributes' => 
                        [
                          'IsCorrect' => false,
                        ],
                      'Sections' => 
                        [
                            [
                            'SectionType' => 'text',
                            'Attributes' => NULL,
                            'Value' => $faker->text(10),
                            ],
                        ],
                    ],
                   
                    [
                      'Attributes' => 
                        [
                           'IsCorrect' => true,
                        ],
                      'Sections' => 
                        [
                        0 => 
                        [
                          'SectionType' => 'text',
                          'Attributes' => NULL,
                          'Value' => $faker->text(10),
                        ],
                        ],
                    ],
                  
                    [
                      'Attributes' => 
                        [
                        'IsCorrect' => false,
                        ],
                      'Sections' => 
                        [
                        0 => 
                        [
                          'SectionType' => 'text',
                          'Attributes' => NULL,
                          'Value' => $faker->text(10),
                        ],
                        ],
                    ],
                    ],
                ],
                'Hints' => 
                    [
                    'Attributes' => NULL,
                    'HintList' => 
                    [
                       
                        [
                        'Attributes' => NULL,
                        'Sections' => 
                            [
                            
                            [
                            'SectionType' => 'text',
                            'Attributes' => NULL,
                            'Value' => $faker->text(15),
                            ],
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]),
        //'exercise_id' => $exerciseid, passed as parameter
        'difficultylevel' =>'easy',
        'hint' => $faker->text(15),

    ];
 });
