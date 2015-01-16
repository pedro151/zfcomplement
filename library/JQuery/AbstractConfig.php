<?php

namespace ZfComplement\JQuery;

abstract class AbstractConfig
{

    protected $defaultOptions = array ();

    public function __construct ( $options = null )
    {
        // The abstract constructor allows no scalar values
        if ( $options instanceof Traversable )
        {
            $options = ArrayUtils::iteratorToArray ( $options );
        }

        if ( is_array ( $options ) )
        {
            $this->setOptions ( $options );
        }
    }


    /**
     * Returns an option
     *
     * @param string $option Option to be returned
     * @return mixed Returned option
     * @throws Exception\InvalidArgumentException
     */
    public function get ( $option )
    {
        if ( array_key_exists ( $option, $this->defaultOptions ) )
        {
            return $this->defaultOptions[ $option ];
        }

        throw new Exception\InvalidArgumentException( "Invalid option '$option'" );
    }

    public function is ( $option )
    {
        if ( array_key_exists ( $option, $this->defaultOptions ) )
        {
            return (bool) $this->defaultOptions[ $option ];
        }
    }

    /**
     * Returns all available options
     *
     * @return array Array with all available options
     */
    public function getOptions ()
    {
        return $this->defaultOptions;
    }

    /**
     * Sets one or multiple options
     *
     * @param  array|Traversable $options Options to set
     * @throws Exception\InvalidArgumentException If $options is not an array or Traversable
     * @return Config Provides fluid interface
     */
    public function setOptions ( $options = array () )
    {
        if ( !is_array ( $options ) && !$options instanceof Traversable )
        {
            throw new Exception\InvalidArgumentException( __METHOD__ . ' expects an array or Traversable' );
        }

        foreach ( $options as $name => $option )
        {
            $fname  = 'set' . ucfirst ( $name );
            $fname2 = 'is' . ucfirst ( $name );
            if ( ( $fname != 'setOptions' ) && method_exists ( $this, $fname ) )
            {
                $this->{$fname}( $option );
            }
            elseif ( method_exists ( $this, $fname2 ) )
            {
                $this->{$fname2}( $option );
            }
            elseif ( array_key_exists ( $name, $this->defaultOptions ) )
            {
                $this->defaultOptions[ $name ] = $option;
            }
        }

        return $this;
    }


    static public function has ( $indice, $options )
    {
        if ( !array_key_exists ( $indice, $options ) )
        {
            throw new Exception\RuntimeException( "Configuration with key '{$indice}' not found" );
        }
    }

}